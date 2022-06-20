<?php

namespace App\Http\Resources\Api;

use Afea\Resume\Transformers\Api\Common\ResumeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            'emailVerifiedAt'   => $this->email_verified_at ?? null,
//            'subscription'      => $this->subscription('default'),

//            'social'            => !$this->password,
        ];
    }
}
