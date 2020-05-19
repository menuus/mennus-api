<?php

namespace App\Models;

use App\User;

class CustomerProfiles extends BaseModel
{
    protected $guarded = [];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function image()
    {
        return $this->belongsTo(Images::class);
    }
}
