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
            'floor' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'is_occupied' => 'nullable|boolean',
        ]);

        // Ensure checkboxes are saved properly
        $data['is_occupied'] = $request->has('is_occupied') ? 1 : 0;

        $room = Room::create($data);

        if ($room) {
            return response()->json([
                'status' => true,
                'message' => 'Room added successfully!',
                'room' => $room,
                'update_url' => route('tenents.update', $room->id),
            ], 201);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!'], 500);
    }

    public function show($id)
    {
        $properties = Property::find($id);
        $rooms = Room::where('property_id', $id)->get();

        return view('masteradmin.pages.rooms.show', compact('rooms', 'properties'));
    }

    public function edit(Room $room)
    {
        $properties = Property::all();

        return view('masteradmin.pages.rooms.edit', compact('room', 'properties'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::find($id);
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'rent' => 'nullable|numeric',
            'floor' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'is_occupied' => 'nullable|boolean',
        ]);

        $data['is_occupied'] = $request->has('is_occupied') ? 1 : 0;

        if ($room->update($data)) {
            return response()->json([
                'status' => true,
                'message' => 'Room updated successfully!',
                'room' => $room->fresh(),
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!'], 500);
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

    public function getUnassignedRooms($propertyId)
    {
        $rooms = Room::where('property_id', $propertyId)->where('is_occupied', 0)
            ->get();

        return response()->json($rooms);
    }
}
