<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelpers;
use App\Helpers\DataHelpers;
use App\Helpers\FunctionsHelper;
use App\Http\Controllers\Controller;
use App\Models\BusinessExercise;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\WorkoutByBusiness;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Session;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    protected $reqtype;

    public function __construct()
    {
        $this->reqtype = request()->expectsJson() ? true : false;
    }

    function dashboard()
    {
        $data = [];
        $data['lastPayment'] = Auth::user()->lastPayment;
        $data['lastWorkout'] = Auth::user()->lastRecordWorkout;
        $data['lastExcercise'] = Auth::user()->lastRecordExcercise;
        $data['lastRecordManyExcercise'] = Auth::user()->lastRecordManyExcercise()->where('reps', '!=', null)->where('weight', '!=', null)->take(5)->get();
        if (Auth::user()->user_type == 'referral')
            $data['renewalDate'] = Auth::user()->businessPlan;
        else
            $data['renewalDate'] = Auth::user()->subscription;
        $data['paymentLogs'] = Auth::user()->paymentLogs()->where('status', 'success')->where('payment_id', '!=', null)->latest()->take(5)->get();

        $data['refferals'] = Auth::user()->allRefferals;

        $chartData = [
            'labels' => $data['lastRecordManyExcercise']->pluck('created_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m/Y')),
            'reps' => $data['lastRecordManyExcercise']->pluck('reps'),
            'weights' => $data['lastRecordManyExcercise']->pluck('weight'),
        ];

        // dd($chartData);
        return view('user.pages.dashboard', compact('data', 'chartData'));
    }

    public function change_password(Request $request)
    {
        // Validate input
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Return success response
        if ($user) {
            return response()->json(['status' => true, 'data' => [], 'message' => 'Password Updated', 'url' => 'reload']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
}
