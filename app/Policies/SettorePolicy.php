<?php

namespace App\Policies;

use App\Models\Settore;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SettorePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
