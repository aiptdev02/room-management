<?php

namespace App\Http\Controllers;

use App\Models\PayingGuest;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->get();
        $properties = Property::all();
        $guests = PayingGuest::all();
        return view('masteradmin.pages.rooms.index', compact('rooms', 'properties', 'guests'));
    }

    public function create()
    {
        $properties = Property::all();

        return view('masteradmin.pages.rooms.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'rent' => 'nullable|numeric',
            'floor' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable|string|max:50',
        ]);

        $save = Room::create($request->all());
        if ($save) {
            return response()->json(['status' => true, 'message' => 'Room added successfully!', 'url' => 'master/rooms']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function show(Room $room)
    {
        return view('masteradmin.pages.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $properties = Property::all();

        return view('masteradmin.pages.rooms.edit', compact('room', 'properties'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'rent' => 'nullable|numeric',
            'floor' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable|string|max:50',
        ]);

        $save = $room->update($data);

        if ($save) {
            return response()->json(['status' => true, 'message' => 'Room updated successfully!', 'url' => 'master/rooms']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function destroy(Room $room)
    {
        if (Auth::guard('masters')->user()->type !== 'master') {
            return redirect()->url('/master/dashboard')->with('success', 'You are not allowed.');
        }
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted!');
    }

    public function getRoomsByProperty($propertyId)
    {
        $rooms = Room::where('property_id', $propertyId)
            ->with(['assignments.guest'])
            ->get();

        return response()->json($rooms);
    }
}
