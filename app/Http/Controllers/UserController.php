<?php

namespace App\Http\Controllers;

use App\Exceptions\MennusUnauthorized;
use App\Models\CustomerProfiles;
use App\Models\EstablishmentProfiles;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller //TODO: extends ResourceBaseController
{
    protected $successStatus = 200;

    public function login(Request $request)
    {
        $loginData = $this->validateAndGetInputData($request, [
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);

        if (!auth()->attempt($loginData))
            throw new MennusUnauthorized('Invalid credentials');

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return $this->respondWithCustomData(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function register(Request $request)
    {
        //TODO: fazer padrao de validator pra todos os controllers
        $validatedData = $this->validateAndGetInputData($request, [ //TODO: centralizar validação com RegisterController
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
            'profile_type' => [ 
                'required', 
                Rule::in(['customer', 'establishment']),
            ],
            'establishment_id' => 'required_if:profile_type,==,establishment|numeric|gt:0|unique:establishment_profiles|exists:establishments,id'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        //TODO: add image
        switch ($validatedData['profile_type']) {
            case 'customer':
                CustomerProfiles::create()->user()->save($user);
                break;

            case 'establishment':
                EstablishmentProfiles::create([
                    'establishment_id' => $validatedData['establishment_id'],
                ])->user()->save($user);
                break;
        }

        $accessToken = $user->createToken('authToken')->accessToken;

        return $this->respondWithCustomData(['user' => $user, 'access_token' => $accessToken]);
    }

    public function details()
    {
        return $this->respondWithCustomData(Auth::user());
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->respondWithCustomData('Successfully logged out');
    }

    public function unauthorized()
    {
        throw new MennusUnauthorized();
    }
}
