<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'username',
        'password',
        'user_type',
        'activation_token',
        'status',
        'referral',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    function user_aggrement()
    {
        return $this->hasOne(UserAgreement::class, 'user_id', 'id');
    }

    function groups()
    {
        return $this->hasMany(BusinessGroupUser::class, 'user_id', 'id');
    }
    function subscription()
    {
        return $this->hasOne(UserSubscription::class, 'user_id', 'id')->where('status', 'active');
    }

    function refferals()
    {
        return $this->hasMany(User::class, 'referral', 'id')->where('status', 1);
    }

    function allRefferals()
    {
        return $this->hasMany(User::class, 'referral', 'id');
    }

    function businessPlan(){
        return $this->hasOne(UserSubscription::class, 'user_id', 'referral')->where('status', 'active');
    }
    function lastRecordWorkout(){
        return $this->hasOne(RecordTrackExercise::class, 'user_id', 'id')->with('workout')->latest();
    }
    function lastRecordManyWorkout(){
        return $this->hasMany(RecordTrackExercise::class, 'user_id', 'id')->with('recordMeta', 'workout')->latest();
    }
    function lastRecordExcercise(){
        return $this->hasOne(RecordIndividualExercise::class, 'user_id', 'id')->with('exercise')->latest();
    }
    function lastRecordManyExcercise(){
        return $this->hasMany(RecordIndividualExercise::class, 'user_id', 'id')->with('exercise')->latest();
    }
    function lastPayment(){
        return $this->hasOne(PaymentLog::class, 'user_id', 'id')->where('status', 'success')->latest();
    }
    function paymentLogs(){
        return $this->hasMany(PaymentLog::class, 'user_id', 'id')->latest();
    }
}
