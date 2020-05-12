<?php

namespace App\Models;

class Plates extends BaseModel
{
    protected $fillable = ['name', 'description', 'slug', 'price'];

    public function establishment()
    {
        return $this->belongsTo(Establishments::class);
    }

    public function plateCategory()
    {
        return $this->belongsTo(PlateCategories::class, 'plate_category_id');
    }

    public function menuType()
    {
        return $this->belongsTo(MenuTypes::class, 'menu_type_id');
    }

    public function images()
    {
        return $this->belongsToMany(Images::class, 'plates_has_images', 'plate_id', 'image_id');
    }

    public function tags()
    {
        //TODO: convert to array
        return $this->belongsToMany(Tags::class, 'plates_has_tags', 'plate_id', 'tag_id');
    }
}
