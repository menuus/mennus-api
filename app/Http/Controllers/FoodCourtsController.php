<?php

namespace App\Http\Controllers;

use App\Models\FoodCourts;
use Illuminate\Http\Request;

class FoodCourtsController extends Controller
{
    function __construct()
    {
        parent::__construct(FoodCourts::class);
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
