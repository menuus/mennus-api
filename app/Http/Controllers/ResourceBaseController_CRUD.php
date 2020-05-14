<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class ResourceBaseController_CRUD extends ResourceBaseController_JustGets
{
    function __construct($model)
    {
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        return $this->respondWithStoredData($this->model::create($request->all()));
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
