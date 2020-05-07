<?php

namespace App\Models;

class Establishments extends BaseModel
{
    protected $fillable = ['name', 'description', 'slug'];

    public function foodCourt()
    {
        return $this->belongsTo(FoodCourts::class, 'food_court_id');
    }

    public function establishmentCategory()
    {
        return $this->belongsTo(EstablishmentCategories::class, 'establishment_category_id');
    }

    public function plates()
    {
        return $this->hasMany(Plates::class, 'establishment_id');
    }

    public function images()
    {
        return $this->belongsToMany(Images::class, 'establishments_has_images', 'establishment_id', 'image_id');
    }
}
