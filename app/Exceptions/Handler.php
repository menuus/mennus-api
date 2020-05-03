<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Google\Cloud\ErrorReporting\Bootstrap;
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
        if ($request->wantsJson())
            return $this->analyseApiError($exception);

        return parent::render($request, $exception);
    }

    public function analyseApiError(Throwable $exception)
    {
        switch (get_class($exception)) {
            case \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class:
                return $this->respondWithNotFound($exception, 2, 'The requested resource was not found');
            
            case \Spatie\QueryBuilder\Exceptions\InvalidAppendQuery::class:
            case \Spatie\QueryBuilder\Exceptions\InvalidFieldQuery::class:
            case \Spatie\QueryBuilder\Exceptions\InvalidFilterQuery::class:
            case \Spatie\QueryBuilder\Exceptions\InvalidIncludeQuery::class:
            case \Spatie\QueryBuilder\Exceptions\InvalidSortQuery::class:
            case \Spatie\QueryBuilder\Exceptions\UnknownIncludedFieldsQuery::class:
                return $this->respondWithError($exception, 3, $exception->getMessage(), $exception->getStatusCode());
            case \Spatie\QueryBuilder\Exceptions\InvalidDirection::class:
            case \Spatie\QueryBuilder\Exceptions\InvalidFilterValue::class:
                return $this->respondWithBadRequest($exception, 3, $exception->getMessage());
        }
        
        if ($exception instanceof HttpException)
            return $this->respondWithError($exception, 4, 'Http exception: '.$exception->getMessage(), $exception->getStatusCode());

        return $this->respondWithError($exception, 1, 'An unexpected error occurred');
    }
}
