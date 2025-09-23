@extends('masteradmin.layout')

@section('title', 'Edit Room')

@section('content')
    <h2>{{ isset($room) ? 'Edit Room' : 'Add New Room' }}</h2>

    <form action="{{ isset($room) ? route('rooms.update', $room) : route('rooms.store') }}" method="POST" class="form-submit">
        @csrf
        @if (isset($room))
            @method('PUT')
        @endif
        <div class="row">
            <div class="mb-3 col-4">
                <label>Room Number</label>
                <input type="text" name="room_number" class="form-control"
                    value="{{ old('room_number', $room->room_number ?? '') }}" required>
            </div>

            <div class="mb-3 col-4">
                <label>Room Type</label>
                <input type="text" name="room_type" class="form-control"
                    value="{{ old('room_type', $room->room_type ?? '') }}" required>
            </div>

            <div class="mb-3 col-4">
                <label>Capacity</label>
                <input type="number" name="capacity" class="form-control"
                    value="{{ old('capacity', $room->capacity ?? '') }}" required>
            </div>

            <div class="mb-3 col-4">
                <label>Rent (Monthly)</label>
                <input type="number" step="0.01" name="rent" class="form-control"
                    value="{{ old('rent', $room->rent ?? '') }}" required>
            </div>

            <div class="mb-3 col-4">
                <label>Floor</label>
                <input type="text" name="floor" class="form-control" value="{{ old('floor', $room->floor ?? '') }}">
            </div>

            <div class="mb-3 col-4">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description', $room->description ?? '') }}</textarea>
            </div>

            <div class="form-check mb-3 ms-3">
                <input class="form-check-input" type="checkbox" name="is_occupied" value="1"
                    {{ isset($room) && $room->is_occupied ? 'checked' : '' }}>
                <label class="form-check-label">Currently Occupied</label>
            </div>
        </div>

        <button class="btn btn-success">{{ isset($room) ? 'Update' : 'Save' }}</button>
    </form>
@endsection
