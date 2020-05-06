<?php

namespace App\Http\Controllers;

use App\Exceptions\MennusBadRequest;
use App\Exceptions\MennusException;
use App\Exceptions\MennusNotFound;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    protected $defaultSort = '-created_at';

    protected $allowedFilters = [
        'name',
        'description',
        'path',
        'food_courts',
        'establishments',
        'plates',
    ];

    protected $allowedSorts = [
        'updated_at',
        'created_at',
        'name',
        'id',
    ];

    protected $allowedIncludes = [
        'food_courts',
        'establishments',
        'plates',
    ];

    // Target to store an image
    private $targets = [
        'food_court' => \App\Models\FoodCourts::class,
        'establishment' => \App\Models\Establishments::class,
        'plate' => \App\Models\Plates::class,
    ];

    public function __construct()
    {
        parent::__construct(Images::class);
    }

    public function index()
    {
        return parent::index();
    }

    public function store(Request $request)
    {
        if ($request->has('path')) {
            // TODO: Not implemented
            throw new MennusBadRequest('Is not possible create an Image with path. Please upload an image.');
            // return filter_var($request->get('path'), FILTER_VALIDATE_URL) ? 'url valida' : 'url invalida';
        }

        if ($request->missing('image'))
            throw new MennusBadRequest("The 'image' file was not informed. Please upload an image file.");

        if (!$request->hasFile('image'))
            throw new MennusBadRequest("The param 'image' is not a file. Please upload an image file.");

        if ($request->missing('target'))
            throw new MennusBadRequest("The 'target' of the image was not informed. Who does this image belong to? "
                . "(Try target[entity]=id_entity. Alloweds entities: " . implode(", ", array_keys($this->targets)) . ").");

        $targetFromRequest = $request->get('target');

        if (!is_array($targetFromRequest))
            throw new MennusBadRequest("The 'target' must be an array with the entity and the id of who owns the image. Who does this image belong to? "
                . "(Try target[entity]=id_entity. Alloweds entities: " . implode(", ", array_keys($this->targets)) . ").");
        
        if (count(array_keys($targetFromRequest)) != 1)
            throw new MennusBadRequest("The 'target' must have a only key. "
                . "(Try target[entity]=id_entity. Alloweds entities: " . implode(", ", array_keys($this->targets)) . ").");
        
        $target = array_keys($targetFromRequest)[0];
        $id = $targetFromRequest[$target];

        if (!in_array($target, array_keys($this->targets)))
            throw new MennusBadRequest("The target '$target' was unknown. (Try: " . implode(", ", array_keys($this->targets)) . ").");

        try 
        {
            if (empty($relation = $this->targets[$target]::find($id)))
                throw new MennusNotFound("The '$target' with id '$id' was not found.");
        }
        catch (\Illuminate\Database\QueryException $e) {
            throw new MennusBadRequest("Error trying find a target with id '$id' (is a valid big integer?).");
        }

        // Uploading image
        $imageUrl = Storage::disk('gcs')->put("${target}s", $request->file('image'));

        if ($imageUrl == false || empty($imageUrl))
            throw new MennusException("An error occurred while trying to upload the image.");

        //TODO: verify if GOOGLE_CLOUD_DEFAULT_URL already contains a /
        //TODO: mascarar caminho até o google cloud com um endpoint
        $baseUrl = env('GOOGLE_CLOUD_DEFAULT_URL', 'https://storage.googleapis.com/mennus-images');

        $image = Images::create(array_merge($request->all(), ['path' => "$baseUrl/$imageUrl"]));

        $relation->images()->save($image);

        return $this->respondWithStoredData($image);
    }

    public function show(Request $request, $id)
    {
        return parent::show($request, $id);
    }

    public function update(Request $request, $id)
    {
        //TODO: Implements update image
        return parent::update($request, $id);
    }

    public function destroy($id)
    {
        //TODO: Implements delete on GCS
        return parent::destroy($id);
    }
}
