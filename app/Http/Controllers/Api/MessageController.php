<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MessageResource;
use App\Http\Resources\Api\ToMessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $messages  = auth()->user()->messages()->with('to')->select('to_id')->groupBy('to_id')->get();

        return ToMessageResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'to_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        auth()->user()->messages()->create($data);

        return codioResponse([
            'message'  => 'Mesaj gonderildi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(User $user)
    {

        $messages = Message::where(function ($query) use ($user){
            $query->where('user_id', auth()->id())->where('to_id', $user->id);
        })->orWhere(function ($query) use ($user){
            $query->where('user_id', $user->id)->where('to_id',  auth()->id());
        })->simplePaginate(10);
        
        
        return MessageResource::collection($messages);
    }

    public function destroy(User $user){
        
        $messages = Message::where(function ($query) use ($user){
            $query->where('user_id', auth()->id())->where('to_id', $user->id);
        })->orWhere(function ($query) use ($user){
            $query->where('user_id', $user->id)->where('to_id',  auth()->id());
        })->delete();

    }

    public function destroyMessage(Message $message){
        abort_if( auth()->id() != $message->user_id, 404);
        $message->delete();
        return "Deleted";
    }
}
