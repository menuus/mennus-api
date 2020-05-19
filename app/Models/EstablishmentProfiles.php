<?php

namespace App\Models;

use App\User;

class EstablishmentProfiles extends BaseModel
{
    protected $guarded = [];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function establishment()
    {
        return $this->belongsTo(Establishments::class);
    }
}
