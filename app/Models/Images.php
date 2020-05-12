<?php

namespace App\Models;

class Images extends BaseModel_withoutSoftDeletes
{
    protected $fillable = ['name', 'description', 'path', 'local_path'];
    protected $hidden = ['pivot', 'local_path'];

    public function foodCourts()
    {
        return $this->belongsToMany(FoodCourts::class, 'food_courts_has_images', 'image_id', 'food_court_id');
    }

    public function establishments()
    {
        return $this->belongsToMany(Establishments::class, 'establishments_has_images', 'image_id', 'establishment_id');
    }

    public function plates()
    {
        return $this->belongsToMany(Plates::class, 'plates_has_images', 'image_id', 'plate_id');
    }
}
