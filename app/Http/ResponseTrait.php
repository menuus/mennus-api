<?php

namespace App\Http;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
    protected function respondWithNotFound($exception, $code, $msg = 'Resource not found'): JsonResponse
    {
        return $this->respondWithError($exception, $code, $msg, Response::HTTP_NOT_FOUND);
    }

    /**
     * Return with 401 error
     *
     * @return JsonResponse
     */
    protected function respondWithUnauthorized($exception, $code, $msg = 'Unauthorized'): JsonResponse
    {
        return $this->respondWithError($exception, $code, $msg, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Return with 400 error
     *
     * @return JsonResponse
     */
    protected function respondWithBadRequest($exception, $code, $msg): JsonResponse
    {
        return $this->respondWithError($exception, $code, $msg, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Return with error
     *
     * @return JsonResponse
     */
    protected function respondWithError($exception, $code, $message, $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $error = [
            'code' => $code,
            'message' => $message
        ];
        
        if (config('app.debug')) {
            $error['debug_exception'] = [
                'class' => get_class($exception),
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'stack_trace' => str_replace("\n", ' -- ', $exception->getTraceAsString()),
            ];
        }
        
        return new JsonResponse([
            'error' => $error,
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
        abort_if(empty($data), Response::HTTP_NOT_FOUND);
        abort_if($data instanceof \Illuminate\Database\Eloquent\Collection && $data->isEmpty(), Response::HTTP_NOT_FOUND);
        return $data;
    }
}
