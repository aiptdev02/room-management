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
                <select name="paying_guest_id" class="form-control" id="mySelect" required>
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
                <select name="property_id" class="form-control" required>
                    <option value="">-- Select Property --</option>
                    @foreach ($properties as $property)
                        <option value="{{ $property->id }}"
                            {{ isset($property_id) && $property_id == $property->id ? 'selected' : '' }}>
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
        $(document).ready(function() {
            $('#mySelect').select2();
            const urlParams = new URLSearchParams(window.location.search);
            const propertyId = urlParams.get('property_id');
            const roomId = urlParams.get('room_id');

            // Preselect property_id if it exists in URL
            if (propertyId) {
                var $propertySelect = $('select[name="property_id"]');

                // Try to set it only if the option exists
                if ($propertySelect.find('option[value="' + propertyId + '"]').length) {
                    $propertySelect.val(propertyId);
                }

                // Manually trigger change after setting

                setTimeout(() => {
                    $('select[name="property_id"]').trigger('change');
                }, 1000);
            }


            // Handle property change event (fetch rooms)
            $('select[name="property_id"]').on('change', function() {
                var selectedPropertyId = $(this).val();
                console.log(selectedPropertyId);

                if (selectedPropertyId) {
                    $.ajax({
                        url: '/master/rooms/unassigned-rooms/' + selectedPropertyId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var $roomSelect = $('select[name="room_id"]');
                            $roomSelect.empty();
                            $roomSelect.append('<option value="">-- Select Room --</option>');

                            $.each(data, function(key, room) {
                                $roomSelect.append(
                                    '<option value="' +
                                    room.id +
                                    '">' +
                                    room.room_number +
                                    '</option>'
                                );
                            });

                            // ✅ Preselect roomId from URL if available
                            if (roomId) {
                                $roomSelect.val(roomId);
                            }
                        }
                    });
                } else {
                    $('select[name="room_id"]').empty().append(
                        '<option value="">-- Select Room --</option>');
                }
            });
        });
    </script>
@endsection
