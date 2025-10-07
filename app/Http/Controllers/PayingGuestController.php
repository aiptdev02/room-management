<?php

namespace App\Http\Controllers;

use App\Models\PayingGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PayingGuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guests = PayingGuest::with('currentAssignment.room.property')->latest()->paginate(10);

        return view('masteradmin.pages.paying_guests.index', compact('guests'));
    }

    public function create()
    {
        return view('masteradmin.pages.paying_guests.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // File uploads
        $data['photo'] = null;
        $data['aadhar_front_photo'] = null;
        $data['aadhar_back_photo'] = null;

        // Upload main photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('pg_photos'), $filename);
            $data['photo'] = 'pg_photos/'.$filename;
        }

        // Upload Aadhar front
        if ($request->hasFile('aadhar_front_photo')) {
            $file = $request->file('aadhar_front_photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('aadhar_photos'), $filename);
            $data['aadhar_front_photo'] = 'aadhar_photos/'.$filename;
        }

        // Upload Aadhar back
        if ($request->hasFile('aadhar_back_photo')) {
            $file = $request->file('aadhar_back_photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('aadhar_photos'), $filename);
            $data['aadhar_back_photo'] = 'aadhar_photos/'.$filename;
        }

        $save = PayingGuest::create($data);

        if ($save) {
            return response()->json(['status' => true, 'message' => 'Paying Guest added successfully!', 'url' => 'master/paying-guests']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function edit(PayingGuest $payingGuest)
    {
        return view('masteradmin.pages.paying_guests.edit', compact('payingGuest'));
    }

    public function show(PayingGuest $payingGuest)
    {
        return view('masteradmin.pages.paying_guests.show', compact('payingGuest'));
    }

    public function update(Request $request, PayingGuest $payingGuest)
    {
        $data = $this->validateData($request, $payingGuest->id);

        // Replace uploaded files
        foreach (['photo', 'aadhar_front_photo', 'aadhar_back_photo'] as $field) {
            if ($request->hasFile($field)) {

                // Delete existing file if it exists
                if ($payingGuest->$field && file_exists(public_path($payingGuest->$field))) {
                    unlink(public_path($payingGuest->$field));
                }

                // Upload new file directly to public folder
                $file = $request->file($field);
                $filename = time().'_'.$file->getClientOriginalName();

                // Determine folder based on field
                $folder = match ($field) {
                    'photo' => 'pg_photos',
                    'aadhar_front_photo', 'aadhar_back_photo' => 'aadhar_photos',
                };

                $file->move(public_path($folder), $filename);
                $data[$field] = $folder.'/'.$filename;
            }
        }

        $save = $payingGuest->update($data);
        if ($save) {
            return response()->json(['status' => true, 'message' => 'Guest updated successfully!', 'url' => 'master/paying-guests']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function destroy(PayingGuest $payingGuest)
    {
        // Delete files

        if (Auth::guard('masters')->user()->type !== 'master') {
            return redirect()->url('/master/dashboard')->with('success', 'You are not allowed.');
        }
        foreach (['photo', 'aadhar_front_photo', 'aadhar_back_photo'] as $field) {
            if ($payingGuest->$field) {
                Storage::disk('public')->delete($payingGuest->$field);
            }
        }

        $payingGuest->delete();

        return redirect()->route('paying-guests.index')->with('success', 'Guest deleted successfully.');
    }

    private function validateData(Request $request, $id = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'aadhar_number' => 'required|string|unique:paying_guests,aadhar_number,'.$id,
            'date_of_birth' => 'nullable|date',
            'father_name' => 'nullable|string',
            'father_phone' => 'nullable|string',
            'mother_name' => 'nullable|string',
            'mother_phone' => 'nullable|string',
            'emergency_number' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'occupation' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'expected_stay_duration' => 'nullable|integer',
            'rent_amount' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:active,left',
            'photo' => 'nullable|image',
            'aadhar_front_photo' => 'nullable|image',
            'aadhar_back_photo' => 'nullable|image',
        ]);
    }

    private function uploadFile(Request $request, $field)
    {
        if ($request->hasFile($field)) {
            return $request->file($field)->store("paying_guests/{$field}", 'public');
        }

        return null;
    }
}
