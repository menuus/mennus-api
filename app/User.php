<?php

namespace App;

use App\Models\Orders;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'email', 'password', 'push_token'
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [
        'password', 'remember_token', 'deleted_at',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];
    protected $with = ['profile'];

    public function orders()
    { //TODO: tirar daqui
        return $this->hasMany(Orders::class, 'user_id');
    }

    public function profile()
    {
        return $this->morphTo();
    }
}
