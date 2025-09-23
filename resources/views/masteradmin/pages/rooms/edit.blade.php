@extends('masteradmin.layout')

@section('title', 'Edit Room')

@section('content')
    <h2>{{ isset($room) ? 'Edit Room' : 'Add New Room' }}</h2>

    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="property_id" class="form-label">Property</label>
            <select name="property_id" class="form-control" required>
                <option value="">-- Select Property --</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->id }}" {{ $room->property_id == $property->id ? 'selected' : '' }}>
                        {{ $property->name }} ({{ $property->location }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="room_number" class="form-label">Room Number</label>
            <input type="text" name="room_number" class="form-control" value="{{ $room->room_number }}" required>
        </div>

        <div class="mb-3">
            <label for="room_type" class="form-label">Room Type</label>
            <input type="text" name="room_type" class="form-control" value="{{ $room->room_type }}" required>
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" required>
        </div>

        <div class="mb-3">
            <label for="rent" class="form-label">Rent</label>
            <input type="number" step="0.01" name="rent" class="form-control" value="{{ $room->rent }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
