<?php

namespace App\Http\Controllers;

use App\Exceptions\MennusBadRequest;
use App\Exceptions\MennusException;
use App\Exceptions\MennusNotFound;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImagesController extends ResourceBaseController_JustGets
{
    protected $defaultSort = '-created_at';

    // Calculated in parent
    // protected $allowedFilters = [
    //     'name',
    //     'description',
    //     'path',
    //     'food_courts',
    //     'establishments',
    //     'plates',
    // ];

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

    // Targets that can receive the image
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

    public function show(Request $request, $id)
    {
        return parent::show($request, $id);
    }

    public function store(Request $request)
    {
        // A set of validations to request
        $this->validateRequest($request);

        if ($request->missing('path') && $request->missing('image'))
            throw new MennusBadRequest("You need to specify a 'path' or an 'image'.");

        // Validating and getting the target to the image
        $target = $this->getAndValidateTargetFromRequest($request);

        // Getting the image URL
        if ($request->has('path'))
            $params = array_merge($request->all(), [
                'local_path' => null, // It is external storage // TODO: Is there a way to specify this in the model?
            ]);
        else {
            $imageUrl = Storage::cloud()->put($target['name'].'s', $request->file('image'));

            if ($imageUrl == false || empty($imageUrl))
                throw new MennusException("An error occurred while trying to upload the image.");

            $params = array_merge($request->all(), [
                'path' => Storage::cloud()->url($imageUrl), //TODO: mascarar caminho até o cloud com um endpoint
                'local_path' => $imageUrl,
            ]);
        }
        
        $image = Images::create($params);

        // Updating the relation table that contains the new image
        $target['relation']->images()->save($image);

        return $this->respondWithStoredData($image);
    }

    // TODO: test
    // public function update(Request $request, $id)
    // {
    //     throw new MennusNotImplemented("The update image end point was disabled. Please delete the image and create again.");
    // }

    // TODO: re-test
    public function destroy($id)
    {
        $image = $this->ifExists(Images::find($id));

        try
        {
            // If not external, delete the stored image
            if (!empty($image->local_path))
                if (!Storage::cloud()->delete($image->local_path))
                    throw new MennusException("Storage::disk->delete returned false.");
        }
        catch (Throwable $ex)
        {
            Log::warning("An error occurred while trying to delete the image '$image->local_path'");
        }

        $this->model::destroy($image->id);

        return $this->respondWithNoContent();
    }

    // -------------------------------------------------------------------------
    // Auxiliar functions
    // -------------------------------------------------------------------------

    public function validateRequest(Request $request)
    {
        if (($request->hasFile('path')  || $request->has('path')) &&
            ($request->hasFile('image') || $request->has('image')))
            throw new MennusBadRequest('You cant make a request with a path and an image.');

        if ($request->has('image') && !$request->hasFile('image'))
            throw new MennusBadRequest("The param 'image' is not a file. Please upload an image file.");

        if ($request->has('path')) {
            if ($request->hasFile('path'))
                throw new MennusBadRequest("The param 'path' is a file, and not a string. "
                    . "If you want upload an image, use 'image' param.");
            
            if (!filter_var($request->get('path'), FILTER_VALIDATE_URL))
                throw new MennusBadRequest("The 'path' contains an invalid url.");
        }
    }

    public function getAndValidateTargetFromRequest(Request $request)
    {
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

        try {
            if (empty($relation = $this->targets[$target]::find($id)))
                throw new MennusNotFound("The '$target' with id '$id' was not found.");
        } catch (\Illuminate\Database\QueryException $e) {
            throw new MennusBadRequest("Error trying find a target with id '$id' (is a valid big integer?).");
        }

        return [
            'name' => $target,
            'id' => $id,
            'relation' => $relation,
        ];
    }
}
