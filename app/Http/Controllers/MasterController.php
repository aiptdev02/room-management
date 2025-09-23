<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Master;
use App\Models\PayingGuest;
use App\Models\Room;
use App\Models\RoomAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MasterController extends Controller
{
    public function index()
    {
        return view('masteradmin.auth.login');
    }

    function master_login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$token = Auth::guard('masters')->attempt($credentials)) {
            return response()->json(['status' => false, 'data' => null, 'message' => 'Username and passsword not correct'], 401);
        }

        $master = Auth::guard('masters')->user();
        if ($master) {
            Session::put('masterlogin', $master);
            return response()->json(['status' => true, 'message' => 'Login Success!', 'url' => 'master/dashboard']);
        } else {
            return response()->json(['status' => false, 'message' => 'Username and passsword not correct!']);
        }
    }
    public function dashboard()
    {
        // totals
        $totalGuests = PayingGuest::count();
        $activeGuests = PayingGuest::where('status', 'active')->count();

        $totalRooms = Room::count();

        // occupiedRooms: rooms with at least 1 active assignment
        // We assume Room model has activeAssignments relation as earlier suggested.
        $occupiedRooms = Room::withCount([
            'assignments as active_assignments_count' => function ($q) {
                $q->where('is_active', true)
                    ->where(function ($qq) {
                        $qq->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
                    });
            }
        ])->get()->filter(function ($room) {
            return $room->active_assignments_count > 0;
        })->count();

        $vacantRooms = max(0, $totalRooms - $occupiedRooms);

        $occupancyPercent = $totalRooms ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

        // Monthly joins for last 6 months (labels + counts)
        $months = collect();
        $countsMap = [];

        for ($i = 5; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $key = $dt->format('Y-m'); // e.g. 2025-09
            $label = $dt->format('M Y'); // e.g. Sep 2025
            $months->push(['key' => $key, 'label' => $label]);
            $countsMap[$key] = 0;
        }

        $joins = PayingGuest::selectRaw("DATE_FORMAT(joining_date, '%Y-%m') as ym, count(*) as cnt")
            ->whereNotNull('joining_date')
            ->where('joining_date', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        foreach ($joins as $j) {
            $countsMap[$j->ym] = (int) $j->cnt;
        }

        $chartLabels = $months->pluck('label')->toArray();
        $chartData = $months->pluck('key')->map(function ($k) use ($countsMap) {
            return $countsMap[$k] ?? 0;
        })->toArray();

        // Recent items
        $recentGuests = PayingGuest::latest()->take(6)->get();
        $recentAssignments = RoomAssignment::with(['guest', 'room'])->latest()->take(6)->get();

        return view('masteradmin.pages.dashboard', compact(
            'totalGuests',
            'activeGuests',
            'totalRooms',
            'occupiedRooms',
            'vacantRooms',
            'occupancyPercent',
            'chartLabels',
            'chartData',
            'recentGuests',
            'recentAssignments'
        ));
    }

    public function indexList(Request $request)
    {
        // optional search
        $q = $request->get('q');

        $masters = Master::withTrashed()->get()->skip(1);

        return view('masteradmin.pages.masters.index', compact('masters', 'q'));
    }

    public function create()
    {
        return view('masteradmin.pages.masters.create');
    }

    /**
     * Store a newly created subadmin in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:masters,username',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required|string|max:50',
        ]);

        $data['password'] = Hash::make($data['password']);

        Master::create($data);

        return redirect()->route('masters.indexList')->with('success', 'Subadmin created successfully.');
    }

    /**
     * Show the form for editing the specified subadmin.
     */
    public function edit(Master $master)
    {
        return view('masteradmin.pages.masters.edit', compact('master'));
    }

    /**
     * Update the specified subadmin in storage.
     */
    public function update(Request $request, Master $master)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:masters,username,' . $master->id,
            'password' => 'nullable|string|min:6|confirmed',
            'type' => 'required|string|max:50',
        ]);

        // If password provided, hash it; otherwise don't change password
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $master->update($data);

        return redirect()->route('masters.indexList')->with('success', 'Subadmin updated successfully.');
    }

    /**
     * Soft-delete the subadmin.
     */
    public function destroy(Master $master)
    {
        if (Auth::guard('masters')->user()->type !== 'master') {
            return redirect()->url('/master/dashboard')->with('success', 'You are not allowed.');
        }
        $master->delete();
        return redirect()->route('masters.indexList')->with('success', 'Subadmin deleted (soft).');
    }

    /**
     * Restore soft-deleted subadmin.
     */
    public function restore($id)
    {
        if (Auth::guard('masters')->user()->type !== 'master') {
            return redirect()->url('/master/dashboard')->with('success', 'You are not allowed.');
        }
        $master = Master::withTrashed()->findOrFail($id);
        $master->restore();
        return redirect()->route('masters.indexList')->with('success', 'Subadmin restored.');
    }

    public function showChangePasswordForm(Master $master)
    {
        return view('masteradmin.pages.masters.change', compact('master'));
    }

    /**
     * Update the master's password (admin action) — no old password required.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $master = Auth::guard('masters')->user();

        if (!Hash::check($request->input('current_password'), $master->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $master->password = Hash::make($request->input('password'));
        $master->save();

        return redirect()->to('/master/dashboard')->with('success', 'Password changed successfully.');
    }
}
