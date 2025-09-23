<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->paginate(10);
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
            'details' => 'nullable|string',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $photos[] = $file->store('properties', 'public');
            }
        }

        $data['photos'] = $photos;

        Property::create($data);

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
            'details' => 'nullable|string',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $photos = $property->photos ?? [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $photos[] = $file->store('properties', 'public');
            }
        }

        $data['photos'] = $photos;

        $property->update($data);

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }
}
