<?php

namespace App\Models;

class PlateCategories extends BaseModel
{
    protected $fillable = ['name', 'slug', 'description'];

    public function plates()
    {
        return $this->hasMany(Plates::class, 'plate_category_id');
    }
}
