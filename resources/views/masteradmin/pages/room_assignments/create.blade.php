@extends('masteradmin.layout')

@section('title', 'Assign Guest to Room')

@section('content')
    <div class="container">
        <h2>Assign Guest to Room</h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Guest</label>
                <select name="paying_guest_id" class="form-control" required>
                    <option value="">-- Select Guest --</option>
                    @foreach ($guests as $g)
                        <option value="{{ $g->id }}" {{ isset($guestId) && $guestId == $g->id ? 'selected' : '' }}>
                            {{ $g->name }} — {{ $g->phone }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Room</label>
                <select name="room_id" class="form-control" required>
                    <option value="">-- Select Room --</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">
                            {{ $room->room_number }} — {{ $room->room_type }} — Rem: {{ $room->remainingSlots() }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted d-block mt-1">Shows only rooms with free slots</small>
            </div>

            <div class="mb-3">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ today()->toDateString() }}">
            </div>

            <div class="mb-3">
                <label>Notes</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Assign</button>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
        </form>

        <hr>
        <form action="{{ route('assignments.auto') }}" method="POST" class="mt-3">
            @csrf
            <h5>Auto-assign</h5>
            <div class="mb-3">
                <label>Select Guest</label>
                <select name="paying_guest_id" class="form-control" required>
                    <option value="">-- Select Guest --</option>
                    @foreach ($guests as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary">Auto Assign to first available room</button>
        </form>
    </div>
@endsection
