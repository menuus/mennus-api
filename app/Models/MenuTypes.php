<?php

namespace App\Models;

class MenuTypes extends BaseModel
{
    protected $fillable = ['name', 'description', 'slug', 'color'];

    // Converting decimal color to hex
    public function getColorAttribute($value)
    {
        return '#'.dechex($value);
    }

    public function plates()
    {
        return $this->hasMany(Plates::class, 'menu_type_id');
    }
}
