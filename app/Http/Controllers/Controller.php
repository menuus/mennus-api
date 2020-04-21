<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use \App\Http\ResponseTrait;

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

    public function store(Request $request)
    {
        return $this->respondWithStoredData($this->model::create($request->all()));
    }

    public function show(Request $request, $id)
    {
        return $this->respondWithCustomData($this->ifExists($this->findById($id)));
    }

    public function update(Request $request, $id)
    {
        $item = $this->ifExists($this->model::find($id));
        $item->update($request->all());
        return $this->respondWithCustomData($item);
    }

    public function destroy($id)
    {
        $this->ifExists($this->model::destroy($id));
        return $this->respondWithNoContent();
    }

    public function getAllTableColumnsFromModel()
    {
        return (new $this->model())->getTableColumns();
    }

    public function findByFilters(): LengthAwarePaginator
    {
        $perPage = (int) request()->get('limit');
        $perPage = $perPage >= 1 && $perPage <= 100 ? $perPage : 20;

        if (!isset($this->allowedSorts) || !isset($this->allowedFields))
            $allColumns = $this->getAllTableColumnsFromModel();

        //Doc for QueryBuilder: https://github.com/spatie/laravel-query-builder
        return QueryBuilder::for($this->model)
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
