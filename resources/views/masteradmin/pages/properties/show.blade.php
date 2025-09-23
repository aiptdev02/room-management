@extends('masteradmin.layout')

@section('title', $property->name)

@section('content')
    <div class="mt-4">

        {{-- Property Header --}}
        <div class="card shadow-lg border-0 rounded-3 mb-4">
            <div class="card-body">
                <h2 class="card-title text-primary fw-bold mb-3">{{ $property->name }}</h2>
                <p class="mb-1">
                    <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                    <strong>Location:</strong> {{ $property->location }}
                </p>
                <p class="mb-0">
                    <i class="bi bi-info-circle-fill text-secondary me-2"></i>
                    <strong>Details:</strong> {{ $property->details }}
                </p>
            </div>
        </div>

        {{-- Property Photos --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-light fw-semibold">
                <i class="bi bi-images me-2"></i> Property Photos
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @if ($property->featured_photo)
                        <div class="col-md-3 col-sm-6">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset($property->featured_photo) }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;" alt="{{ $property->name }}">
                            </div>
                        </div>
                    @endif
                    @if ($property->photos)
                        @foreach ($property->photos as $photo)
                            <div class="col-md-3 col-sm-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <img src="{{ asset($photo) }}" class="card-img-top rounded"
                                        alt="Property Photo">
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No photos uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Rooms Section --}}
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-light fw-semibold">
                <i class="bi bi-door-open me-2"></i> Rooms in this Property
            </div>
            <div class="card-body">
                @forelse($property->rooms as $room)
                    <div class="d-flex align-items-center justify-content-between border-bottom py-2">
                        <div>
                            <span class="badge bg-primary me-2">Room {{ $room->room_number }}</span>
                            <span class="text-muted">({{ $room->room_type }})</span>
                        </div>
                        <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-sm btn-outline-secondary">
                            View Details
                        </a>
                    </div>
                @empty
                    <p class="text-muted">No rooms assigned yet.</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection
