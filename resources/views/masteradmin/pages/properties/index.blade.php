@extends('masteradmin.layout')

@section('title', 'Properties')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Properties</h2>
        <a href="{{ route('properties.create') }}" class="btn btn-primary mb-3">Add Property</a>
    </div>

    <div class="row">
        @forelse($properties as $property)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    {{-- Property Image --}}
                    <div class="p-3">
                        @if ($property->featured_photo)
                            <img src="{{ asset($property->featured_photo) }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;" alt="{{ $property->name }}">
                        @else
                            <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;" alt="No Image">
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $property->name }}</h5>
                        <p class="card-text">
                            <strong>Location:</strong> {{ $property->location }} <br>
                            <strong>Details:</strong> {{ Str::limit($property->details, 80) }}<br>
                            <strong>Total Rooms:</strong> {{ count($property->rooms) }}
                        </p>
                        <div class="mt-1">
                            <a href="{{ route('properties.show', $property->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('properties.destroy', $property->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this property?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No properties available.</p>
        @endforelse
    </div>
    {{ $properties->links() }}
@endsection
