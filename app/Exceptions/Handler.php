<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    use \App\Http\ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldntReport($exception))
            return;

        if (is_callable($reportCallable = [$exception, 'report'])) {
            $this->container->call($reportCallable);

            return;
        }

        $fmtError = $this->formatError($exception);

        // Is running in google cloud?
        if (isset($_SERVER['GAE_SERVICE'])) {
            Log::alert("Unhandled exception -- $fmtError -- Stack trace: -- ".$exception->getTraceAsString());
        } else {
            Log::alert("Unhandled exception -- $fmtError");

            Log::channel('unhandled--stacktrace-daily')
                ->alert("Unhandled exception -- $fmtError\nStack trace:\n".$exception->getTraceAsString()."\n\n");
        }
    }

    public function formatError(Throwable $exception)
    {
        return get_class($exception) . '['
            . $exception->getCode() . ']:"'
            . $exception->getMessage() . '" in '
            . $exception->getFile() . ':'
            . $exception->getLine();
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        //TODO: sempre retornar json se for uma requisição para /api
        if ($request->wantsJson())
            return $this->analyseApiError($exception);

        return parent::render($request, $exception);
    }

    public function analyseApiError(Throwable $exception)
    {
        //TODO: tratar BadMethodCallException - getAditionalfieldAttribute()
        switch (get_class($exception)) {
            case \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class:
            case \Illuminate\Database\Eloquent\ModelNotFoundException::class:
                return $this->respondWithNotFound($exception, ErrorCode::ResourceNotFound, 'The requested resource was not found');
            
            // Replaced by the "instanceof Invalid Query"
            // case \Spatie\QueryBuilder\Exceptions\InvalidAppendQuery::class:
            // case \Spatie\QueryBuilder\Exceptions\InvalidFieldQuery::class:
            // case \Spatie\QueryBuilder\Exceptions\InvalidFilterQuery::class:
            // case \Spatie\QueryBuilder\Exceptions\InvalidIncludeQuery::class:
            // case \Spatie\QueryBuilder\Exceptions\InvalidSortQuery::class:
            // case \Spatie\QueryBuilder\Exceptions\UnknownIncludedFieldsQuery::class:
            //     return $this->respondWithError($exception, 3, $exception->getMessage(), $exception->getStatusCode());
            case \Spatie\QueryBuilder\Exceptions\InvalidDirection::class:
            case \Spatie\QueryBuilder\Exceptions\InvalidFilterValue::class:
                return $this->respondWithBadRequest($exception, ErrorCode::QueryBuilder, $exception->getMessage());
        }

        // TODO: ver \Symfony\Component\ErrorHandler\Error\FatalError (quando nao reconhece a classe e precisa executar um composer dumpautoload)

        if ($exception instanceof \Spatie\QueryBuilder\Exceptions\InvalidQuery)
            return $this->respondWithError($exception, ErrorCode::QueryBuilder, "Invalid query exception: " . $exception->getMessage(), $exception->getStatusCode());

        if ($exception instanceof \App\Exceptions\MennusNotImplemented) {
            Log::critical('A not implemented excepetion as raised: '.$exception->getMessage());
            return $this->respondWithError($exception, ErrorCode::MennusException, $exception->getMessage(), $exception->getStatusCode());
        }
            
        if ($exception instanceof \App\Exceptions\MennusException) {
            Log::critical('A mennus exception as raised.');
            return $this->respondWithError($exception, ErrorCode::MennusException, $exception->getMessage(), $exception->getStatusCode());
        }

        
        if ($exception instanceof HttpException)
            return $this->respondWithError($exception, ErrorCode::HttpException, 'Http exception: '.$exception->getMessage(), $exception->getStatusCode());

        return $this->respondWithError($exception, ErrorCode::Unknown, 'An unexpected error occurred');
    }
}
