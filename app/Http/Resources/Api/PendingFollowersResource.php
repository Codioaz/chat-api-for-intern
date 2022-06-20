<?php

namespace App\Http\Resources\Api;

use Afea\Resume\Transformers\Api\Common\ResumeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PendingFollowersResource extends JsonResource
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
            'userId'            => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'routes'            => [
                'approve'       => route('api.v1.auth.user.approve', $this->id),
                'cancel'        => route('api.v1.auth.user.reject', $this->id)
            ]
        ];
    }
}
