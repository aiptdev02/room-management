@extends('masteradmin.layout')

@section('title', $property->name)

@section('content')
    <h2>{{ $property->name }}</h2>
    <p><strong>Location:</strong> {{ $property->location }}</p>
    <p><strong>Details:</strong> {{ $property->details }}</p>

    <h5>Photos</h5>
    <div class="d-flex flex-wrap">
        @if ($property->photos)
            @foreach ($property->photos as $photo)
                <img src="{{ asset('storage/' . $photo) }}" width="150" class="me-2 mb-2">
            @endforeach
        @endif
    </div>

    <h5>Rooms in this Property</h5>
    <ul>
        @forelse($property->rooms as $room)
            <li>
                Room {{ $room->room_number }} ({{ $room->room_type }})
                <a href="{{ route('rooms.show', $room->id) }}">View</a>
            </li>
        @empty
            <li>No rooms assigned yet.</li>
        @endforelse
    </ul>
@endsection
