<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait FollowerTrait
{
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    public function following(): BelongsToMany
    {
        return $this->BelongsToMany(User::class,'followers','follower_id','user_id');
    }

    public function hasBeenSendRequest($where =[ true, false ]): bool
    {
        return (bool) $this->followers()->wherePivotIn('approved', $where)->where('id', auth()->id())->count();
    }

    public function sendRequest(): void
    {
        if ($this->hasBeenSendRequest()) return ;

        $this->followers()->syncWithoutDetaching([ auth()->id() => [ 'approved' => false ] ]);
    }


    public function approveRequest(): void
    {

    }


    public function cancelRequest(): void
    {

    }
}
