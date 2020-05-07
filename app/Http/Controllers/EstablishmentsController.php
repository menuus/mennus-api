<?php

namespace App\Http\Controllers;

use App\Models\Establishments;
use Illuminate\Http\Request;


class EstablishmentsController extends Controller
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
        'food_court',
        'establishment_category',
        'images',
        'plates',
    ];

    function __construct()
    {
        parent::__construct(Establishments::class);
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
