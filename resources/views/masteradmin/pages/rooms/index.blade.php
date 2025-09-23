@extends('masteradmin.layout')

@section('title', 'Rooms')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Rooms</h2>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">Add Room</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Room #</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Rent</th>
                <th>Occupied</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rooms as $room)
                <tr>
                    <td>{{ $room->room_number }}</td>
                    <td>{{ $room->room_type }}</td>
                    <td>{{ $room->capacity }}</td>
                    <td>₹{{ $room->rent }}</td>
                    <td>{{ $room->is_occupied ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning btn-sm">Edit</a>
                        @if (Auth::guard('masters')->user()->type === 'master')
                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this room?')"
                                    class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
