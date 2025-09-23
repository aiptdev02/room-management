@extends('masteradmin.layout')

@section('title', 'Room Details')

@section('content')
    <div class="py-4">
        <!-- Breadcrumb and Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Room {{ $room->room_number }}</h2>
            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary mb-4"><i class="bi bi-arrow-left"></i>
                Back</a>
        </div>


        <!-- Room Overview Card -->
        <div class="card shadow-sm mb-4 rounded-3">
            <div class="card-header bg-primary text-white rounded-top">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <h3 class="mb-0"><i class="bi bi-door-open"></i> Room {{ $room->room_number }}</h3>
                    <span class="badge bg-light text-dark rounded-pill h-50">Status:
                        {{ $room->currentOccupancy() === $room->capacity ? 'Full' : 'Available' }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="bg-light rounded p-3 h-100">
                            <p class="mb-0"><strong><i class="bi bi-building text-primary"></i> Property</strong><br>
                                <small class="text-muted">{{ $room->property->name }}</small><br>
                                <i class="bi bi-geo-alt"></i> {{ $room->property->location }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="bg-light rounded p-3 h-100">
                            <p class="mb-0"><strong><i class="bi bi-tag-fill text-info"></i> Type</strong><br>
                                <span class="badge bg-info text-dark">{{ $room->room_type }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="bg-light rounded p-3 h-100">
                            <p class="mb-0"><strong><i class="bi bi-cash-coin text-success"></i> Rent</strong><br>
                                <span class="text-success fs-5">₹{{ number_format($room->rent, 2) }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="bg-light rounded p-3 h-100">
                            <p class="mb-0"><strong><i class="bi bi-people-fill text-primary"></i> Capacity</strong><br>
                                {{ $room->capacity }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div
                            class="rounded p-3 h-100 {{ $room->currentOccupancy() > 0 ? 'bg-success text-white' : 'bg-light' }}">
                            <p class="mb-0"><strong><i class="bi bi-person-fill"></i> Occupied</strong><br>
                                <span
                                    class="badge bg-{{ $room->currentOccupancy() > 0 ? 'light' : 'secondary' }} text-dark">{{ $room->currentOccupancy() }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="rounded p-3 h-100 {{ $room->remainingSlots() < 1 ? 'bg-light' : 'bg-warning' }}">
                            <p class="mb-0"><strong><i class="bi bi-signpost-split"></i> Remaining</strong><br>
                                <span
                                    class="badge bg-{{ $room->remainingSlots() < 1 ? 'secondary' : 'warning text-dark' }}">{{ $room->remainingSlots() }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Assignments Card -->
        <div class="card shadow-sm rounded-3 mb-4">
            <div class="card-header bg-secondary text-white rounded-top">
                <div class="d-flex align-items-center">
                    <i class="bi bi-card-checklist me-2"></i>
                    <h4 class="mb-0">Active Assignments</h4>
                </div>
            </div>
            <div class="card-body">
                @if ($room->activeAssignments()->count() > 0)
                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        @foreach ($room->activeAssignments as $assignment)
                            <div class="col">
                                <div class="card h-100 border-primary shadow-sm rounded-3 overflow-hidden">
                                    <div class="card-header bg-primary text-white">
                                        <span
                                            class="badge bg-{{ $assignment->is_active ? 'success' : 'secondary' }}">{{ $assignment->is_active ? 'Active' : 'Inactive' }}</span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $assignment->occupant_name ?? 'Unknown' }}</h5>
                                        <p class="card-text mb-0"><strong><i class="bi bi-calendar-check"></i>
                                                Check-in:</strong>
                                            {{ \Carbon\Carbon::parse($assignment->start_date)->format('d M Y') }}</p>
                                        <p class="card-text mb-0"><strong><i class="bi bi-calendar-x"></i> End
                                                Date:</strong>
                                            {{ $assignment->end_date ? \Carbon\Carbon::parse($assignment->end_date)->format('d M Y') : 'Ongoing' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center p-4">
                        <i class="bi bi-calendar-x fs-1 text-muted mb-2"></i>
                        <p class="text-muted">No active assignments for this room.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-primary">Edit Details</a>
            <a href="#" class="btn btn-outline-success me-md-2">New Assignment</a>
        </div>
    </div>
@endsection
