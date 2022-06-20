<?php

namespace App\Classes\Api;

use App\Http\Resources\Api\AuthResource;

class OAuth
{
    public static function mergedToken($auth): array
    {
        $data = collection_to_array(new AuthResource($auth));
        $token = $auth->createToken('front react');
        $data['tokenType'] = 'Bearer';
        $data['accessToken'] = $token->plainTextToken;
        return $data;
    }

    public static function authMergedToken($auth): array
    {
        $data = collection_to_array(new AuthResource($auth));
        $token = $auth->createToken('front react');
        $data['tokenType'] = 'Bearer';
        $data['accessToken'] = $token->plainTextToken;
        return $data;
    }
}
