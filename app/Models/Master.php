<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Master extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'password',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isType(string $role): bool
    {
        return strtolower($this->type) === strtolower($role);
    }
}
