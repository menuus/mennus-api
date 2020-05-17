<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

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
        return (new $this->model())->getTableColumnsNames();
    }

    public function getTableFiltersFromModel()
    {
        $filters = [];

        $modelInstance = new $this->model();

        foreach ($modelInstance->getTableColumnsNames() as $columnName)
            array_push($filters,
                $modelInstance->getColumnType($columnName) == 'string' ?
                    AllowedFilter::partial($columnName) :
                    AllowedFilter::exact($columnName)
            );

        return $filters;
    }

    public function findByFilters(): LengthAwarePaginator
    {
        $perPage = (int) request()->get('limit');
        $perPage = $perPage >= 1 && $perPage <= 100 ? $perPage : 20;

        if (!isset($this->allowedSorts) || !isset($this->allowedFields))
            $allColumns = $this->getAllTableColumnsFromModel();
        
        $filters = $this->allowedFilters ?? $this->getTableFiltersFromModel();

        //Doc for QueryBuilder: https://github.com/spatie/laravel-query-builder
        return QueryBuilder::for($this->model)
            // ->select($this->defaultSelect) // Its probably useless
            ->allowedFields($this->allowedFields ?? $allColumns)
            ->allowedFilters($filters)
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
