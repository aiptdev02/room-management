@extends('masteradmin.layout')

@section('title', 'Guest Details')

@section('content')
    <div class="container">
        <h2 class="mb-3">Guest Details</h2>

        @php $assignment = $payingGuest->currentAssignment()->first(); @endphp

        @if ($assignment)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Current Room</h5>
                    <p><strong>Room:</strong> {{ $assignment->room->room_number }} — {{ $assignment->room->room_type }}</p>
                    <p><strong>Start:</strong> {{ $assignment->start_date }}</p>
                    <form action="{{ route('assignments.unassign', $assignment->id) }}" method="POST"
                        onsubmit="return confirm('Unassign guest from room?');">
                        @csrf
                        <button class="btn btn-warning">Unassign</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-info">No active room assignment. <a
                    href="{{ route('assignments.create', ['guest_id' => $payingGuest->id]) }}">Assign now</a></div>
        @endif

        <div class="card">
            <div class="card-body row">
                <div class="col-md-3">
                    <strong>Photo:</strong><br>
                    @if ($payingGuest->photo)
                        <img src="{{ asset($payingGuest->photo) }}" class="img-fluid rounded mb-2">
                    @endif
                </div>

                <div class="col-md-9">
                    <p><strong>Name:</strong> {{ $payingGuest->name }}</p>
                    <p><strong>Phone:</strong> {{ $payingGuest->phone }}</p>
                    <p><strong>Email:</strong> {{ $payingGuest->email }}</p>
                    <p><strong>Aadhar Number:</strong> {{ $payingGuest->aadhar_number }}</p>
                    <p><strong>Date of Birth:</strong> {{ $payingGuest->date_of_birth }}</p>
                    <p><strong>Father:</strong> {{ $payingGuest->father_name }} ({{ $payingGuest->father_phone }})</p>
                    <p><strong>Mother:</strong> {{ $payingGuest->mother_name }} ({{ $payingGuest->mother_phone }})</p>
                    <p><strong>Emergency Contact:</strong> {{ $payingGuest->emergency_number }}</p>
                    <p><strong>Occupation:</strong> {{ $payingGuest->occupation }}</p>
                    <p><strong>Joining Date:</strong> {{ $payingGuest->joining_date }}</p>
                    <p><strong>Rent Amount:</strong> ₹{{ $payingGuest->rent_amount }}</p>
                    <p><strong>Notes:</strong> {{ $payingGuest->notes }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($payingGuest->status) }}</p>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <h5>Aadhar Front</h5>
                @if ($payingGuest->aadhar_front_photo)
                    <img src="{{ asset($payingGuest->aadhar_front_photo) }}" class="img-fluid rounded">
                @endif
            </div>
            <div class="col-md-6">
                <h5>Aadhar Back</h5>
                @if ($payingGuest->aadhar_back_photo)
                    <img src="{{ asset($payingGuest->aadhar_back_photo) }}" class="img-fluid rounded">
                @endif
            </div>
        </div>

        <a href="{{ route('paying-guests.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
@endsection
