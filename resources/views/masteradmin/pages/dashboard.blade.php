@extends('masteradmin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Dashboard</h2>
            <a href="{{ route('masters.indexList') }}" class="btn btn-outline-secondary">Manage Subadmins</a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card p-3">
                    <h6 class="mb-1">Total Paying Guests</h6>
                    <h3 class="mb-0">{{ $totalGuests }}</h3>
                    <small class="text-muted">Active: {{ $activeGuests }}</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <h6 class="mb-1">Total Rooms</h6>
                    <h3 class="mb-0">{{ $totalRooms }}</h3>
                    <small class="text-muted">Vacant: {{ $vacantRooms }}</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <h6 class="mb-1">Occupied Rooms</h6>
                    <h3 class="mb-0">{{ $occupiedRooms }}</h3>
                    <small class="text-muted">Occupancy: {{ $occupancyPercent }}%</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <h6 class="mb-1">Actions</h6>
                    <a href="{{ route('rooms.create') }}" class="btn btn-sm btn-success w-100 mb-1">Add Room</a>
                    <a href="{{ route('paying-guests.create') }}" class="btn btn-sm btn-primary w-100 mb-1">Add
                        Guest</a>
                    <a href="{{ route('assignments.create') }}" class="btn btn-sm btn-outline-primary w-100">Assign
                        Guest</a>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card p-3">
                    <h5>New Joining (Last 6 months)</h5>
                    <canvas id="joinsChart" height="120"></canvas>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Recent Guests</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($recentGuests as $g)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>{{ $g->name }}</strong><br>
                                        <small class="text-muted">{{ $g->phone }}</small>
                                    </div>
                                    <div class="text-end">
                                        <small
                                            class="text-muted">{{ $g->joining_date ? \Carbon\Carbon::parse($g->joining_date)->format('d M, Y') : '' }}</small><br>
                                        <a href="{{ route('paying-guests.show', $g->id) }}"
                                            class="btn btn-sm btn-link">View</a>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item">No recent guests</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="card p-3">
            <h5>Recent Assignments</h5>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Start</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAssignments as $a)
                            <tr>
                                <td>{{ $a->guest->name ?? '—' }}<br><small
                                        class="text-muted">{{ $a->guest->phone ?? '' }}</small></td>
                                <td>{{ $a->room->room_number ?? '—' }}<br><small
                                        class="text-muted">{{ $a->room->room_type ?? '' }}</small></td>
                                <td>{{ $a->start_date ? \Carbon\Carbon::parse($a->start_date)->format('d M, Y') : '-' }}
                                </td>
                                <td>
                                    @if ($a->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Ended</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('paying-guests.show', $a->paying_guest_id) }}"
                                        class="btn btn-sm btn-link">Guest</a>
                                    <a href="{{ route('rooms.show', $a->room_id) }}"
                                        class="btn btn-sm btn-link">Room</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No recent assignments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($chartLabels) !!};
        const data = {!! json_encode($chartData) !!};

        const ctx = document.getElementById('joinsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'New Guests',
                    data: data,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection
