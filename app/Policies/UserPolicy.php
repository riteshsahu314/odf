<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $signedInUser)
    {
        // if thread user id == authenticated user id
        return $user->id == $signedInUser->id;
    }
}
