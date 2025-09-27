<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('rooms')->latest()->paginate(10);

        return view('masteradmin.pages.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('masteradmin.pages.properties.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'total_rooms' => 'nullable|integer',
            'details' => 'nullable|string',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $data['featured_photo'] = null;
        if ($request->hasFile('featured_photo')) {
            $file = $request->file('featured_photo');
            $filename = time().'_'.$file->getClientOriginalName();

            // Save directly to public/properties
            $file->move(public_path('properties'), $filename);

            $data['featured_photo'] = 'properties/'.$filename;
        }

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();

                // Save directly to public/properties
                $file->move(public_path('properties'), $filename);

                $photos[] = 'properties/'.$filename;
            }
        }

        $data['photos'] = $photos;

        $property = Property::create($data);

        // Create Rooms
        if ($property && $request->total_rooms > 0) {
            for ($i = 1; $i <= $request->total_rooms; $i++) {
                Room::create([
                    'property_id' => $property->id,
                    'room_number' => "R{$i}",
                    'room_type' => 'Standard', // default
                    'capacity' => 1,
                    'status' => 'available',
                ]);
            }
        }

        return redirect()->route('properties.index')->with('success', 'Property created successfully.');
    }

    public function show(Property $property)
    {
        return view('masteradmin.pages.properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        return view('masteradmin.pages.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'total_rooms' => 'nullable|integer|min:0',
            'details' => 'nullable|string',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        // Featured photo
        $data['featured_photo'] = $property->featured_photo ?? null;
        if ($request->hasFile('featured_photo')) {
            $file = $request->file('featured_photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('properties'), $filename);
            $data['featured_photo'] = 'properties/'.$filename;
        }

        // Multiple photos
        $photos = $property->photos ?? [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('properties'), $filename);
                $photos[] = 'properties/'.$filename;
            }
        }
        $data['photos'] = $photos;

        // Update Property
        $property->update($data);

        // 🔑 Room Sync
        $currentRoomCount = $property->rooms()->count();
        $newRoomCount = $request->total_rooms ?? 0;

        if ($newRoomCount > $currentRoomCount) {
            // Add new rooms
            for ($i = $currentRoomCount + 1; $i <= $newRoomCount; $i++) {
                Room::create([
                    'property_id' => $property->id,
                    'room_number' => "R{$i}",
                    'room_type' => 'Standard',
                    'capacity' => 1,
                    'status' => 'available',
                ]);
            }
        } elseif ($newRoomCount < $currentRoomCount) {
            // Remove extra rooms (latest added)
            $roomsToDelete = $property->rooms()
                ->orderBy('id', 'desc')
                ->take($currentRoomCount - $newRoomCount)
                ->get();

            foreach ($roomsToDelete as $room) {
                $room->delete();
            }
        }

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }
}
