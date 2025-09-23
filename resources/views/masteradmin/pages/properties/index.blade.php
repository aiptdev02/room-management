@extends('masteradmin.layout')

@section('title', 'Properties')

@section('content')
        <h2>Properties</h2>
        <a href="{{ route('properties.create') }}" class="btn btn-primary mb-3">Add Property</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Rooms</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $property)
                    <tr>
                        <td>{{ $property->name }}</td>
                        <td>{{ $property->location }}</td>
                        <td>{{ $property->rooms->count() }}</td>
                        <td>
                            <a href="{{ route('properties.show', $property->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('properties.destroy', $property->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No properties found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $properties->links() }}
@endsection
