<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'paying_guest_id',
        'room_id',
        'property_id',
        'rent_amount',
        'electricity_charges',
        'other_charges',
        'month',
        'is_paid',
    ];

    // Relationships
    public function guest()
    {
        return $this->belongsTo(PayingGuest::class, 'paying_guest_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
