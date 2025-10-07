<?php

namespace App\Http\Controllers;

use App\Models\PayingGuest;
use App\Models\Property;
use App\Models\RentCollection;
use App\Models\Room;
use Illuminate\Http\Request;

class RentCollectionController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::all();

        return view('masteradmin.pages.rent_collections.index', compact('properties'));
    }

    public function create()
    {
        $guests = PayingGuest::with('currentRoom')->get();

        return view('masteradmin.pages.rent_collections.create', compact('guests'));
    }

    public function store(Request $request)
    {
        $guests = PayingGuest::with('currentRoom')->where('id', $request->paying_guest_id)->first();
        $request->validate([
            'paying_guest_id' => 'required|exists:paying_guests,id',
            'rent_amount' => 'required|numeric',
            'month' => 'required',
        ]);

        RentCollection::create([
            'paying_guest_id' => $request->paying_guest_id,
            'room_id' => $guests->currentRoom->room->id,
            'property_id' => $guests->currentRoom->room->property->id,
            'rent_amount' => $request->rent_amount,
            'electricity_charges' => $request->electricity_charges,
            'other_charges' => $request->other_charges,
            'month' => $request->month,
            'is_paid' => $request->has('is_paid'),
        ]);

        return redirect()->route('rent_collections.index')->with('success', 'Rent collected successfully!');
    }

    public function show($id)
    {
        // $rents = RentCollection::with('property')->where('property_id', $id)->get();
        $rents = Room::with('property', 'singleassignments.guest', 'rentCollection')->where('property_id', $id)->get();

        return view('masteradmin.pages.rent_collections.show', compact('rents'));
    }

    // RentCollectionController.php

    public function update(Request $request, RentCollection $rentCollection)
    {
        $data = $request->validate([
            'rent_amount' => 'required|numeric',
            'month' => 'required|string',
            'electricity_charges' => 'nullable|numeric',
            'other_charges' => 'nullable|numeric',
            'is_paid' => 'nullable|boolean',
        ]);

        $data['is_paid'] = $request->has('is_paid');

        $rentCollection->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Rent updated successfully!',
        ]);
    }
}
