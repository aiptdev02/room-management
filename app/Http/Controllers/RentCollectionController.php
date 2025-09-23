<?php

namespace App\Http\Controllers;

use App\Models\PayingGuest;
use App\Models\Property;
use App\Models\RentCollection;
use Illuminate\Http\Request;

class RentCollectionController extends Controller
{
    public function index(Request $request)
    {
        $query = RentCollection::with(['guest', 'room', 'property']);

        // Filters
        if ($request->month) {
            $query->where('month', $request->month);
        }

        if ($request->property_id) {
            $query->where('property_id', $request->property_id);
        }

        $rents = $query->get();

        $properties = Property::all();

        return view('masteradmin.pages.rent_collections.index', compact('rents', 'properties'));
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
}
