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
                <label>Property</label>
                <select name="property_id" class="form-control" required >
                    <option value="">-- Select Property --</option>
                    @foreach ($properties as $property)
                        <option value="{{ $property->id }}" {{ isset($property_id) && $property_id == $property->id ? 'selected' : '' }}>
                            {{ $property->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted d-block mt-1">Shows only rooms with free slots</small>
            </div>

            <div class="mb-3">
                <label>Room</label>
                <select name="room_id" class="form-control" required>
                    <option value="">-- Select Room --</option>

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
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection

@section('page_script')
    <script>
        $('select[name="property_id"]').on('change', function() {
            var propertyId = $(this).val();
            if (propertyId) {
                $.ajax({
                    url: '/master/rooms/unassigned-rooms/' + propertyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var roomSelect = $('select[name="room_id"]');
                        roomSelect.empty();
                        roomSelect.append('<option value="">-- Select Room --</option>');
                        $.each(data, function(key, room) {
                            roomSelect.append('<option value="' + room.id + '">' + room
                                .room_number + ' — ' + room.room_type + ' — Rem: ' + room
                                .remaining_slots + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="room_id"]').empty().append('<option value="">-- Select Room --</option>');
            }
        });
    </script>
@endsection
