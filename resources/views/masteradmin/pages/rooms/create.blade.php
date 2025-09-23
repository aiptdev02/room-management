@extends('masteradmin.layout')

@section('title', 'Add Room')

@section('content')
    <h2>Add Room</h2>
    <form action="{{ route('rooms.store') }}" method="POST" class="form-submit">
        @csrf

        <div class="mb-3">
            <label for="property_id" class="form-label">Property</label>
            <select name="property_id" class="form-control" required>
                <option value="">-- Select Property --</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->id }}">{{ $property->name }} ({{ $property->location }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="room_number" class="form-label">Room Number</label>
            <input type="text" name="room_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="room_type" class="form-label">Room Type</label>
            <input type="text" name="room_type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="rent" class="form-label">Rent (optional)</label>
            <input type="number" step="0.01" name="rent" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
@endsection
