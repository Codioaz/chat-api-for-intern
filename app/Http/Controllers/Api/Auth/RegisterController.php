<?php

namespace App\Http\Controllers\Api\Auth;

use App\Classes\Api\GuestHelper;
use App\Classes\Api\OAuth;
use App\Classes\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): \Illuminate\Http\Response
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        try {

            $user = User::create($data);

            return codioResponse([ 'data' => OAuth::authMergedToken($user) ]);
        }catch (\Exception $exception){
            return codioResponse(['message' => 'error' ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
