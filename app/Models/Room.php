<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'property_id',
        'room_number',
        'room_type',
        'capacity',
        'rent',
        'floor',
        'description',
        'is_occupied',
    ];

    public function assignments()
    {
        return $this->hasMany(RoomAssignment::class);
    }
    public function singleassignments()
    {
        return $this->hasOne(RoomAssignment::class);
    }

    /**
     * Active assignments currently occupying this room.
     */
    public function activeAssignments()
    {
        return $this->assignments()->where('is_active', true)
            ->where(function ($q) {
                // active if end_date is null or end_date >= today
                $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
            });
    }

    /**
     * Number of currently occupied slots.
     */
    public function currentOccupancy()
    {
        return $this->activeAssignments()->count();
    }

    /**
     * Remaining free slots.
     */
    public function remainingSlots()
    {
        return max(0, $this->capacity - $this->currentOccupancy());
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function rentCollection()
    {
        return $this->hasOne(RentCollection::class);
    }
}
