<?php

namespace App\Http\Controllers;

use App\Models\PayingGuest;
use App\Models\Property;
use App\Models\Room;
use App\Models\RoomAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomAssignmentController extends Controller
{
    /**
     * Show form to assign a guest (choose guest and room).
     */
    public function create(Request $request)
    {
        // Optionally accept guest_id param to pre-select guest
        $guestId = $request->get('guest_id');

        // list guests (you can limit to unassigned or all)
        $guests = PayingGuest::orderBy('name')->get();

        $properties = Property::all();

        return view('masteradmin.pages.room_assignments.create', compact('guests', 'guestId', 'properties'));
    }

    /**
     * Store new assignment (assign guest to room) — capacity check inside.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'paying_guest_id' => 'required|exists:paying_guests,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $guest = PayingGuest::findOrFail($data['paying_guest_id']);
        $room = Room::findOrFail($data['room_id']);

        // Prevent assigning a guest already actively assigned
        $already = $guest->assignments()->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
            })
            ->exists();

        if ($already) {
            return back()->with('error', 'This guest already has an active room assignment.');
        }

        // use a DB transaction to avoid race conditions
        DB::beginTransaction();
        try {
            // re-check capacity in DB to avoid race condition
            $room = Room::lockForUpdate()->find($room->id);
            if ($room->remainingSlots() <= 0) {
                DB::rollBack();

                return back()->with('error', 'Room has no free slots left. Choose another room.');
            }

            $start = $data['start_date'] ?? now()->toDateString();

            $assignment = RoomAssignment::create([
                'paying_guest_id' => $guest->id,
                'room_id' => $room->id,
                'start_date' => $start,
                'is_active' => true,
                'notes' => $data['notes'] ?? null,
            ]);

            // Optionally update room.is_occupied if full
            if ($room->remainingSlots() <= 1) {
                $room->update(['is_occupied' => true]);
            }

            DB::commit();

            return redirect()->route('tenents.show', $room->id)->with('success', 'Guest assigned to room.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // log error in real app
            return back()->with('error', 'Failed to assign guest. Try again.');
        }
    }

    /**
     * Auto assign: find first room with available slots and assign guest.
     */
    public function autoAssign(Request $request)
    {
        $data = $request->validate([
            'paying_guest_id' => 'required|exists:paying_guests,id',
        ]);

        $guest = PayingGuest::findOrFail($data['paying_guest_id']);

        // Prevent double assignment
        $already = $guest->assignments()->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
            })
            ->exists();
        if ($already) {
            return back()->with('error', 'Guest already has an active assignment.');
        }

        // Find first room with remainingSlots > 0
        $room = Room::all()->first(function ($r) {
            return $r->remainingSlots() > 0;
        });

        if (! $room) {
            return back()->with('error', 'No rooms have free slots.');
        }

        // reuse assign logic (transaction)
        return $this->assignGuestToRoom($guest, $room);
    }

    /**
     * Reusable assignment function (returns redirect response)
     */
    protected function assignGuestToRoom(PayingGuest $guest, Room $room, $startDate = null, $notes = null)
    {
        DB::beginTransaction();
        try {
            $room = Room::lockForUpdate()->find($room->id);
            if ($room->remainingSlots() <= 0) {
                DB::rollBack();

                return back()->with('error', 'Room has no free slots left.');
            }

            $assignment = RoomAssignment::create([
                'paying_guest_id' => $guest->id,
                'room_id' => $room->id,
                'start_date' => $startDate ?? now()->toDateString(),
                'is_active' => true,
                'notes' => $notes,
            ]);

            if ($room->remainingSlots() <= 1) {
                $room->update(['is_occupied' => true]);
            }

            DB::commit();

            return redirect()->route('tenents.show', $room->id)->with('success', 'Assigned successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Assignment failed.');
        }
    }

    /**
     * Unassign (end) an assignment.
     */
    public function unassign(Request $request, RoomAssignment $assignment)
    {
        $request->validate([
            'end_date' => 'nullable|date',
        ]);

        if (! $assignment->is_active) {
            return back()->with('error', 'Assignment already inactive.');
        }

        DB::beginTransaction();
        try {
            $assignment->update([
                'end_date' => $request->get('end_date') ?? now()->toDateString(),
                'is_active' => false,
            ]);

            // update room is_occupied flag if needed
            $room = Room::lockForUpdate()->find($assignment->room_id);
            if ($room->remainingSlots() > 0 && $room->is_occupied) {
                $room->update(['is_occupied' => false]);
            }

            DB::commit();

            return back()->with('success', 'Guest unassigned from room.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to unassign.');
        }
    }
}
