<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'paying_guest_id',
        'room_id',
        'start_date',
        'end_date',
        'is_active',
        'notes',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function guest()
    {
        return $this->belongsTo(PayingGuest::class, 'paying_guest_id');
    }
}
