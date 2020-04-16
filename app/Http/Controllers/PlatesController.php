<?php

namespace App\Http\Controllers;

use App\Models\Plates;
use Illuminate\Http\Request;

class PlatesController extends Controller
{
    function __construct()
    {
        parent::__construct(Plates::class);
    }

    public function index()
    {
        return parent::index();
    }

    public function store(Request $request)
    {
        return parent::store($request);
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function update(Request $request, $id)
    {
        return parent::update($request, $id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }
}
