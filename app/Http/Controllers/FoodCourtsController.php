<?php

namespace App\Http\Controllers;

use App\Models\FoodCourts;
use Illuminate\Http\Request;

class FoodCourtsController extends ResourceBaseController_CRUD
{
    protected $defaultSort = '-created_at';

    protected $allowedFilters = [
        'name',
        'slug',
        'description',
    ];

    protected $allowedSorts = [
        'updated_at',
        'created_at',
        'name',
        'id',
    ];

    protected $allowedIncludes = [
        'establishments',
        'images',
    ];

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

    public function show(Request $request, $id)
    {
        return parent::show($request, $id);
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
