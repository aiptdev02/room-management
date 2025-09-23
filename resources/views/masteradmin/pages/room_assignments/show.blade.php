@php $assignment = $payingGuest->currentAssignment()->first(); @endphp

@if ($assignment)
    <div class="card mb-3">
        <div class="card-body">
            <h5>Current Room</h5>
            <p><strong>Room:</strong> {{ $assignment->room->room_number }} — {{ $assignment->room->room_type }}</p>
            <p><strong>Start:</strong> {{ $assignment->start_date }}</p>
            <form action="{{ route('admin.assignments.unassign', $assignment->id) }}" method="POST"
                onsubmit="return confirm('Unassign guest from room?');">
                @csrf
                <button class="btn btn-warning">Unassign</button>
            </form>
        </div>
    </div>
@else
    <div class="alert alert-info">No active room assignment. <a
            href="{{ route('admin.assignments.create', ['guest_id' => $payingGuest->id]) }}">Assign now</a></div>
@endif
