<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FollowersResource;
use App\Http\Resources\Api\PendingFollowersResource;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function pending(){
        return PendingFollowersResource::collection(auth()->user()->followers()->wherePivot('approved', false)->get());
    }

    public function approve(User $user): \Illuminate\Http\Response
    {
        auth()->user()->approveRequest($user['id']);

        return codioResponse([
            'message' => 'Takib istəyin qəbul etdin '
        ]);
    }
    public function reject(User $user): \Illuminate\Http\Response
    {
        auth()->user()->rejectRequest($user['id']);

        return codioResponse([
            'message' => 'Takib istəyin ləğv etdin '
        ]);
    }

    public function cancel(User $user): \Illuminate\Http\Response
    {
        auth()->user()->cancelRequest($user['id']);

        return codioResponse([
            'message' => 'Takib istəyin ləğv etdin '
        ]);
    }

    public function follow(User $user): \Illuminate\Http\Response
    {
        if ($user->hasBeenSendRequest()){
            return codioResponse([
                'message' => 'Daha öncə sorğu göndərmisən! '
            ]);
        }

        $user->sendRequest();

        return codioResponse([
           'message' => 'Takib sorğu göndərildi!'
        ]);
    }
}
