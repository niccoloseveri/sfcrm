<?php

namespace App\Policies;

use App\Models\User;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user) : bool
    {
        return !($user->isAssistente() || $user->isPt());
    }
}
