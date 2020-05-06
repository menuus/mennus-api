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

class MennusBadRequest extends MennusException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}

class MennusNotFound extends MennusException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }
}

class MennusNotImplemented extends MennusException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}