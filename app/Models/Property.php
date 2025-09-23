<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'location', 'details', 'photos'];

    protected $casts = [
        'photos' => 'array',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
