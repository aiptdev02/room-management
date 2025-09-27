@extends('masteradmin.layout')

@section('title', 'Manage Rooms')

@section('content')
    <div class="">

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
                                <strong>Total Rooms:</strong> {{ Str::limit($property->total_rooms, 80) }}<br>
                            </p>
                            <div class="mt-1">
                                <a href="{{ route('tenents.show', $property->id) }}" class="btn btn-info btn-sm">View Rooms</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No properties available.</p>
            @endforelse
        </div>
    </div>
@endsection
