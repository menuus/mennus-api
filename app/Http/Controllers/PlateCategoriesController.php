<?php

namespace App\Http\Controllers;

use App\Models\PlateCategories;
use Illuminate\Http\Request;

class PlateCategoriesController extends Controller
{
    protected $defaultSort = 'id';

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

    protected $allowedIncludes = [];

    function __construct()
    {
        parent::__construct(PlateCategories::class);
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
