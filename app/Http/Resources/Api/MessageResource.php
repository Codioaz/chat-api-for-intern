<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'userId'        => $this->user_id,
            'toId'          => $this->to_id,
            'me'            => $this->user_id == auth()->id(),
            'message'       => $this->message,
            'createdAt'     => $this->created_at
        ];
    }
}
