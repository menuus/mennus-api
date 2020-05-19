<?php

namespace App\Models;

use App\User;

class Orders extends BaseModel
{
    protected $fillable = ['obs'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function establishment()
    {
        return $this->belongsTo(Establishments::class, 'establishment_id');
    }

    public function plates()
    {
        return $this->belongsToMany(Plates::class, 'orders_has_plates', 'order_id', 'plate_id')
            ->withPivot('plates_amount', 'price');
    }
}
