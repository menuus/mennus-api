<?php

namespace App\Http;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

//TODO: refatorar. Essa classe está assumindo o controle de exception, e não deveria estar aqui

trait ResponseTrait
{
    /**
     * The current path of resource to respond
     *
     * @var string
     */
    // protected $resourceItem;

    /**
     * The current path of collection resource to respond
     *
     * @var string
     */
    // protected $resourceCollection;

    protected function respondWithStoredData($data): JsonResponse
    {
        return $this->respondWithCustomData($data, Response::HTTP_CREATED);
    }
    
    protected function respondWithCustomData($data, $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse([
            'data' => $data,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()],
        ], $status);
    }

    protected function getTimestampInMilliseconds(): int
    {
        return intdiv((int)now()->format('Uu'), 1000);
    }

    /**
     * Return no content for delete requests
     *
     * @return JsonResponse
     */
    protected function respondWithNoContent(): JsonResponse
    {
        return new JsonResponse([
            'data' => null,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()],
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return with 404 error
     *
     * @return JsonResponse
     */
    protected function respondWithNotFound(): JsonResponse
    {
        return $this->respondWithError(2, 'Resource not found', Response::HTTP_NOT_FOUND);
    }

    /**
     * Return with error
     *
     * @return JsonResponse
     */
    protected function respondWithError($code, $message, $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return new JsonResponse([
            'error' => [
                'code' => $code,
                'message' => $message
            ],
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()],
        ], $status);
    }

    /**
     * Return collection response from the application
     *
     * @param LengthAwarePaginator $collection
     * @return mixed
     */
    protected function respondWithCollection(LengthAwarePaginator $collection)
    {
        return (new ResourceCollection($collection))->additional(
            ['meta' => ['timestamp' => $this->getTimestampInMilliseconds()]]
        );
    }

    /**
     * Return single item response from the application
     *
     * @param Model $item
     * @return mixed
     */
    protected function respondWithItem(Model $item)
    {
        return (new JsonResource($item))->additional(
            ['meta' => ['timestamp' => $this->getTimestampInMilliseconds()]]
        );
    }

    /**
     * Abort code with response 404 if $data is null
     *
     * @param mixed $data
     * @return mixed
     */
    protected function ifExists($data)
    {
        abort_if(!$data, Response::HTTP_NOT_FOUND);
        return $data;
    }
}
