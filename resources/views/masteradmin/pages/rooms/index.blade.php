@extends('masteradmin.layout')

@section('title', 'Manage Rooms')

@section('content')
    <div class="">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Rooms</h2>
            <a href="{{ route('rooms.create') }}" class="btn btn-primary">Add Room</a>
        </div>

        <!-- Property Dropdown -->
        <div class="mb-4">
            <label for="propertySelect" class="form-label">Select Property</label>
            <select id="propertySelect" class="form-select">
                <option value="">All Properties</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Rooms Card Container -->
        <div id="roomsContainer" class="row g-4">
            @foreach ($rooms as $room)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $room->name }}</h5>
                            <p class="card-text"><strong>Property:</strong> {{ $room->property->name }}</p>
                            <p class="card-text">{{ Str::limit($room->details, 80) }}</p>
                            <p class="card-text"><strong>Rent:</strong> ₹{{ number_format($room->rent, 2) }}</p>
                            <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary btn-sm">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('propertySelect').addEventListener('change', function() {
            const propertyId = this.value;

            fetch(`/rooms/filter/${propertyId}`)
                .then(res => res.json())
                .then(data => {
                    let container = document.getElementById('roomsContainer');
                    container.innerHTML = '';

                    if (data.length === 0) {
                        container.innerHTML = `<p>No rooms found for this property.</p>`;
                    } else {
                        data.forEach(room => {
                            container.innerHTML += `
                            <div class="col-md-4">
                                <div class="card shadow-sm h-100">
                                    <img src="${room.featured_photo
                                                ? '/storage/' + room.featured_photo
                                                : 'https://via.placeholder.com/300x200?text=No+Image'}"
                                         class="card-img-top"
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">${room.name}</h5>
                                        <p class="card-text"><strong>Property:</strong> ${room.property_name}</p>
                                        <p class="card-text">${room.details ? room.details.substring(0, 80) : ''}</p>
                                        <p class="card-text"><strong>Rent:</strong> ₹${room.rent}</p>
                                        <a href="/rooms/${room.id}" class="btn btn-primary btn-sm">View</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        });
                    }
                });
        });
    </script>
@endsection
