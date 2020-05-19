<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

abstract class ResourceBaseController_JustGets extends Controller
{
    private $model;

    // protected $defaultSort = '';
    // protected $allowedFields = [];
    // protected $allowedFilters = [];
    // protected $allowedSorts = [];
    // protected $allowedIncludes = [];

    function __construct($model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->respondWithCollection($this->ifExists($this->findByFilters()));
    }

    public function show(Request $request, $id)
    {
        return $this->respondWithCustomData($this->ifExists($this->findById($id)));
    }

    public function getAllTableColumnsFromModel()
    {
        return (new $this->model())->getTableColumns();
    }

    public function findByFilters(int $userId=null): LengthAwarePaginator
    {
        $perPage = (int) request()->get('limit');
        $perPage = $perPage >= 1 && $perPage <= 100 ? $perPage : 20;

        if (!isset($this->allowedSorts) || !isset($this->allowedFields))
            $allColumns = $this->getAllTableColumnsFromModel();
        
        $model = $userId ? 
            $this->model::where('user_id', $userId) : 
            $this->model;

        //Doc for QueryBuilder: https://github.com/spatie/laravel-query-builder
        return QueryBuilder::for($model)
            // ->select($this->defaultSelect) // Its probably useless
            ->allowedFields($this->allowedFields ?? $allColumns)
            ->allowedFilters($this->allowedFilters ?? '') //TODO: add filters by int, timestamp, float
            ->allowedIncludes($this->allowedIncludes ?? '')
            ->allowedSorts($this->allowedSorts ?? $allColumns)
            ->defaultSort($this->defaultSort ?? 'id')
            ->paginate($perPage);
    }

    public function findById($id)
    {
        $allowedFields = $this->allowedFields ?? $this->getAllTableColumnsFromModel();

        //Doc for QueryBuilder: https://github.com/spatie/laravel-query-builder
        return QueryBuilder::for($this->model::where('id', $id))
            // ->select($this->defaultSelect) // Its probably useless
            ->allowedFields($allowedFields)
            ->allowedIncludes($this->allowedIncludes ?? '') //TODO: limit returned data in includes fields
            ->first();
    }
}
