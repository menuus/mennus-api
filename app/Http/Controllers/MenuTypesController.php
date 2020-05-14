<?php

namespace App\Http\Controllers;

use App\Models\MenuTypes;
use Illuminate\Http\Request;

class MenuTypesController extends ResourceBaseController_CRUD
{
    protected $defaultSort = 'id';

    protected $allowedFilters = [
        'name',
        'slug',
        'description',
        'color',
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
        parent::__construct(MenuTypes::class);
    }

    public function index()
    {
        return parent::index();
    }

    public function store(Request $request)
    {
        // Converting hex color to decimal value
        $params = $request->has('color') && ctype_xdigit($request->get('color'))
            ? array_merge($request->all(), [ 'color' => hexdec($request->get('color')) ])
            : $request->all();
        return $this->respondWithStoredData(MenuTypes::create($params));
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
