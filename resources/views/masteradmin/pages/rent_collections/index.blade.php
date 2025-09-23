@extends('masteradmin.layout')

@section('title', 'Rent Collection')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Rent Collection</h2>
        <a href="{{ route('rent_collections.create') }}" class="btn btn-primary mb-3">Collect Rent</a>
    </div>

    <table class="table table-bordered">
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
                <tr>
                    <td>{{ $rent->guest->name }}</td>
                    <td>{{ $rent->room->room_number ?? '-' }}</td>
                    <td>{{ $rent->property->name ?? '-' }}</td>
                    <td>{{ $rent->rent_amount }}</td>
                    <td>{{ $rent->month }}</td>
                    <td>{{ $rent->electricity_charges }}</td>
                    <td>{{ $rent->other_charges }}</td>
                    <td>
                        @if ($rent->is_paid)
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-danger">Unpaid</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('/master/send-reminder') }}/{{ $rent->guest->id }}" class="btn btn-sm btn-success">
                            Send WhatsApp Reminder
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
