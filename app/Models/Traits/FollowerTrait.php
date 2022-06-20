<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait FollowerTrait
{
    // istifadəçinin followerleri
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'followers', //table
            'user_id', //senin idin
            'follower_id' //takib etdiyinin idisi
        );
    }

    // istifadəçinin follow ettikleri
    public function following(): BelongsToMany
    {
        return $this->BelongsToMany(
            User::class,
            'followers', //table
            'follower_id', // senin idin
            'user_id' //sorgu gonderdiyin istifadecinin idisi
        );
    }

    // kimese sorgu gonderib $this - sorgu gonderdiyi istifadecidir
    public function hasBeenSendRequest($where =[ true, false ]): bool
    {
        return (bool) $this->followers()
            ->wherePivotIn('approved', $where) // qebul edilmis ve ya edilmemis sorgularin ucun query
            ->where('id', auth()->id())
            ->count();
    }

    // follow sorugu gonder
    public function sendRequest(): void
    {
        $this->followers()->syncWithoutDetaching([
            auth()->id() => [
                'approved' => false
            ]
        ]);
    }

    // gelen sorugunu qebul etmek
    public function approveRequest($followerId): void
    {
        $this->followers()
            ->syncWithoutDetaching([
                $followerId => [
                    'approved' => true
                ]
            ]);
    }

    // gelen sorugunu legv etmek
    public function rejectRequest($followerId): void
    {
        $this->followers()
            ->detach($followerId);
    }

    // gonderdiyin sorgunu iptal etmek
    public function cancelRequest($userId): void
    {
        $this->following()
            ->detach($userId);
    }
}
