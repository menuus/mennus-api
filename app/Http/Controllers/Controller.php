<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use \App\Http\ResponseTrait;

    protected $model;

    public function index()
    {
        //TODO: trocar por respondWithCollection
        //TODO: ordenar
        return $this->respondWithCustomData($this->ifExists($this->model::all()));
    }

    public function store(Request $request)
    {
        return $this->respondWithStoredData($this->model::create($request->all()));
    }

    public function show($id)
    {
        return $this->respondWithCustomData($this->ifExists($this->model::find($id)));
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
}
