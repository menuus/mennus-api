<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class MennusValidationError extends MennusException
{
    public function __construct($errors, string $message = "Validation error.")
    {
        $this->errors = $errors;
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}