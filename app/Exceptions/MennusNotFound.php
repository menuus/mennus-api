<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class MennusNotFound extends MennusException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }
}
