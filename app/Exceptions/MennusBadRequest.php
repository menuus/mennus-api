<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class MennusBadRequest extends MennusException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}