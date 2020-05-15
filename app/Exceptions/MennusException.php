<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;

class MennusException extends HttpException
{
    public function __construct(string $message, int $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($httpStatusCode, $message);
    }
}
