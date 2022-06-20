<?php

namespace App\Http\Controllers\User;

use App\Classes\Api\OAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function show(): Response
    {
        $auth = auth()->user();
        return codioResponse([ 'data' => OAuth::mergedToken($auth) ]);
    }

    public function update(Request $request): \Illuminate\Http\Response
    {
        $data = $request->validate([
            'name' => 'required|string|max:225'
        ]);
        $message = __('Profile updated successfully');

        $request->whenFilled('password', function () use ($request, &$data) {
            $request->validate([
                'password' => ['required', 'string', 'confirmed'],
            ]);

            return $data['password'] = bcrypt($request->get('password'));
        });

        if (array_key_exists('password', $data)){
            $message = __('Profile and password updated successfully');
        }

        auth()->user()->update($data);

        return codioResponse([
            'message' => $message,
            'data' => OAuth::mergedToken(auth()->user())
        ]);
    }
}
