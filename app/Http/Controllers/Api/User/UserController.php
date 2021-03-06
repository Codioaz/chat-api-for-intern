<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::where(
            'id', 
            '<>', 
            auth()->id()
        )->orderBy('id', 'desc')
            ->get();

        return AuthResource::collection($users);
    }
}
