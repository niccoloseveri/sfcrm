<?php

namespace App\Policies;

use App\Models\User;
use Edwink\FilamentUserActivity\Models\UserActivity;
use Illuminate\Auth\Access\Response;



class UserActivityPolicy
{
    /**
    * Determine whether the user can view any models.
    */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
