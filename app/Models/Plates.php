<?php

namespace App\Models;

class Plates extends BaseModel
{
    protected $fillable = ['name', 'description', 'slug'];

    public function establishment()
    {
        return $this->belongsTo(Establishments::class);
    }

    public function images()
    {
        return $this->belongsToMany(Images::class, 'plates_has_images', 'plate_id', 'image_id');
    }
}
