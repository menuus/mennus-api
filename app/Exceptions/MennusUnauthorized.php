<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class MennusUnauthorized extends MennusException
{
    public function __construct(string $message = "Unauthorized.")
    {
        parent::__construct($message, Response::HTTP_UNAUTHORIZED);
    }
}