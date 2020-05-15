<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Exceptions\MennusValidationError;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use \App\Http\ResponseTrait;

    public function validateAndGetInputData(Request $request, $validations)
    {
        $validator = Validator::make($request->all(), $validations);
        if ($validator->fails())
            throw new MennusValidationError($validator->errors());
        
        return $validator->validated();
    }
}
