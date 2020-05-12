<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model // TODO: migrar para _withoutBaseModel
{
    protected $fillable = ['tag'];
    public $timestamps = false;
    protected $hidden = ['id', 'pivot'];

    public function plates()
    {
        return $this->belongsToMany(Plates::class, 'plates_has_tags', 'tag_id', 'plate_id');
    }
}
