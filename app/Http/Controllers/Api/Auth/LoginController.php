<?php

namespace App\Http\Controllers\Api\Auth;

use App\Classes\Api\OAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(LoginRequest $request): \Illuminate\Http\Response
    {
        $credentials = $request->only('email','password');

        if (! auth()->attempt($credentials)){
            return codioResponse([
                'message' => __('The given data was invalid.'),
                'errors'  => [
                    'password' => [
                        __('The given data was invalid.')
                    ]
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return codioResponse([ 'data' => OAuth::authMergedToken(auth()->user()) ]);
    }

}
