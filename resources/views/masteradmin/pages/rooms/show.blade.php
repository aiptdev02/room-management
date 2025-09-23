@extends('masteradmin.layout')

@section('title', 'Room Details')

@section('content')
    <h2>Room {{ $room->room_number }}</h2>
    <p><strong>Property:</strong> {{ $room->property->name }} ({{ $room->property->location }})</p>
    <p><strong>Type:</strong> {{ $room->room_type }}</p>
    <p><strong>Capacity:</strong> {{ $room->capacity }}</p>
    <p><strong>Rent:</strong> {{ $room->rent }}</p>

    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
@endsection
