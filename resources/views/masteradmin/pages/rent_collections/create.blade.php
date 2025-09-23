@extends('masteradmin.layout')

@section('title', 'Collect Rent')

@section('content')
<div class="container">
    <h2>Collect Rent</h2>
    <form action="{{ route('rent_collections.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="paying_guest_id">Select Guest</label>
            <select name="paying_guest_id" class="form-control" required>
                <option value="">-- Select Guest --</option>
                @foreach($guests as $guest)
                    <option value="{{ $guest->id }}">
                        {{ $guest->name }} (Room: {{ $guest->currentRoom->room->room_number ?? '-' }}, Property: {{ $guest->currentRoom->room->property->name ?? '-' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Rent Amount</label>
            <input type="number" name="rent_amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Month</label>
            <input type="month" name="month" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Electricity Charges</label>
            <input type="number" name="electricity_charges" class="form-control">
        </div>

        <div class="mb-3">
            <label>Other Charges</label>
            <input type="number" name="other_charges" class="form-control">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_paid" class="form-check-input" id="is_paid">
            <label class="form-check-label" for="is_paid">Mark as Paid</label>
        </div>

        <button type="submit" class="btn btn-success">Submit Rent</button>
    </form>
</div>
@endsection
