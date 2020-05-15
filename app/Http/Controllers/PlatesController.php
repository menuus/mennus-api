<?php

namespace App\Http\Controllers;

use App\Models\Plates;
use Illuminate\Http\Request;

class PlatesController extends ResourceBaseController_CRUD
{
    protected $defaultSort = '-created_at';

    // protected $allowedFields = [
    //     'id',
    //     'name',
    //     'slug',
    //     'description',
    //     'created_at',
    //     'updated_at',
    // ];
    
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
        'price',
    ];

    protected $allowedIncludes = [
        'establishment',
        'menu_type',
        'plate_category',
        'images',
    ];

    public function __construct()
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
