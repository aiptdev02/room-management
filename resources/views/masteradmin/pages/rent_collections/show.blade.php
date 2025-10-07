@extends('masteradmin.layout')

@section('title', 'Rent Collection')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Rent Collection - {{ $rents[0]?->property->name }}</h2>
        {{-- <a href="{{ route('rent_collections.create') }}" class="btn btn-primary mb-3">Collect Rent</a> --}}
    </div>

    <table class="table table-bordered" id="rent-table">
        <thead>
            <tr>
                <th>Guest</th>
                <th>Room</th>
                <th>Property</th>
                <th>Rent</th>
                <th>Month</th>
                <th>Electricity</th>
                <th>Other</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rents as $rent)
                <tr data-id="{{ $rent->id }}">
                    <td>{{ $rent->singleassignments->guest->name ?? 'Not Assigned' }}</td>
                    <td>{{ $rent->room_number ?? '-' }}</td>
                    <td>{{ $rent->property->name ?? '-' }}</td>

                    {{-- Editable fields --}}
                    <td><input type="number" class="form-control rent_amount" value="{{ $rent->rent }}"></td>
                    <td>
                        @php
                            $monthValue = $rent->rentCollection->month ?? '';
                            $formattedMonth = $monthValue ? \Carbon\Carbon::createFromFormat('Y-m', $monthValue)->format('F Y') : '';
                        @endphp
                        <input type="text" class="form-control month" value="{{ $formattedMonth }}">
                    </td>
                    <td><input type="number" class="form-control electricity_charges"
                            value="{{ $rent->rentCollection->electricity_charges ?? 0}}"></td>
                    <td><input type="number" class="form-control other_charges" value="{{ $rent->rentCollection->other_charges ?? 0}}"></td>

                    <td>
                        <select class="form-control is_paid">
                            <option value="0" {{ !$rent->is_paid ? 'selected' : '' }}>Unpaid</option>
                            <option value="1" {{ $rent->is_paid ? 'selected' : '' }}>Paid</option>
                        </select>
                    </td>

                    <td>
                        <button class="btn btn-sm btn-success update-rent">Update</button>

                        @if ($rent->singleassignments)
                            <a href="{{ url('/master/send-reminder/' . $rent->singleassignments->guest->id) }}"
                                class="btn btn-sm btn-warning reminder-btn"
                                style="{{ $rent->is_paid ? 'display:none;' : '' }}">
                                Send WhatsApp Reminder
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            $('.update-rent').click(function() {
                let row = $(this).closest('tr');
                let id = row.data('id');

                $.ajax({
                    url: "/master/rent_collections/" + id,
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        rent_amount: row.find('.rent_amount').val(),
                        month: row.find('.month').val(),
                        electricity_charges: row.find('.electricity_charges').val(),
                        other_charges: row.find('.other_charges').val(),
                        is_paid: row.find('.is_paid').val(),
                    },
                    success: function(res) {
                        if (res.status) {
                            alert(res.message);

                            // Hide reminder button if paid
                            if (row.find('.is_paid').val() == "1") {
                                row.find('.reminder-btn').hide();
                            } else {
                                row.find('.reminder-btn').show();
                            }
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
