@extends('masteradmin.layout')

@section('title', 'Paying Guests')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Paying Guests</h3>
        <a href="{{ route('paying-guests.create') }}" class="btn btn-primary">Add Guest</a>
    </div>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Aadhar</th>
                <th>Property</th>
                <th>Room</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guests as $guest)
                <tr>
                    <td>{{ $guest->name }}</td>
                    <td>{{ $guest->phone }}</td>
                    <td>{{ $guest->aadhar_number }}</td>
                    <td>{{ $guest?->currentAssignment?->room?->property?->name }}</td>
                    <td>{{ $guest?->currentAssignment?->room?->room_number }}</td>
                    <td>{{ ucfirst($guest->status) }}</td>
                    <td>
                        <a href="{{ route('paying-guests.show', $guest) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('paying-guests.edit', $guest) }}" class="btn btn-sm btn-warning">Edit</a>
                        @if (Auth::guard('masters')->user()->type === 'master')
                            <form action="{{ route('paying-guests.destroy', $guest->id) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this guest?')">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $guests->links() }}
@endsection
