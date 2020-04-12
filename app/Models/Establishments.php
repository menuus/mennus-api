<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Establishments extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'slug'];
    protected $dates = ['deleted_at'];
}
