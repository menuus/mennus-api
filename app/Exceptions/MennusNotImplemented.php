<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class MennusNotImplemented extends MennusException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}