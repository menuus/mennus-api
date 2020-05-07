<?php

namespace App\Models;

class EstablishmentCategories extends BaseModel
{
    protected $fillable = ['name', 'slug'];

    public function establishments()
    {
        return $this->hasMany(Establishments::class, 'establishment_category_id');
    }
}
