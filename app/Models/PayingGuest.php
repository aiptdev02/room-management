<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayingGuest extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'photo',
        'aadhar_number',
        'aadhar_front_photo',
        'aadhar_back_photo',
        'date_of_birth',
        'father_name',
        'father_phone',
        'mother_name',
        'mother_phone',
        'emergency_number',
        'permanent_address',
        'occupation',
        'joining_date',
        'expected_stay_duration',
        'rent_amount',
        'notes',
        'status',
    ];

    public function assignments()
    {
        return $this->hasMany(RoomAssignment::class, 'paying_guest_id');
    }

    /**
     * Current active assignment (nullable).
     */
    public function currentAssignment()
    {
        return $this->hasOne(RoomAssignment::class, 'paying_guest_id')->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
            });
    }

    /**
     * Helper to get the active room directly (or null).
     */
    public function currentRoom()
    {
        return $this->currentAssignment()->with('room.property');
    }

}
