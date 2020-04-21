<?php

namespace App\Models;

class FoodCourts extends BaseModel
{
    protected $fillable = ['name', 'description', 'slug'];

    public function establishments()
    {
        return $this->hasMany(Establishments::class, 'food_court_id');
    }

    public function images()
    {
        return $this->belongsToMany(Images::class, 'food_courts_has_images', 'food_court_id', 'image_id');
    }
}
