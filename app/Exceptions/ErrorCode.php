<?php 

namespace App\Exceptions;

abstract class ErrorCode
{
    const Unknown = 1;
    const MennusException = 2;
    const ResourceNotFound = 3;
    const QueryBuilder = 4;
    const HttpException = 5;
}