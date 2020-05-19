<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel_withoutSoftDeletes extends Model
{
    protected $hidden = ['pivot'];

    public function getTableColumnsNames()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    
    public function getColumnType(string $colName)
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnType($this->getTable(), $colName);
    }
}

class BaseModel extends BaseModel_withoutSoftDeletes
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ['deleted_at', 'pivot'];
}
