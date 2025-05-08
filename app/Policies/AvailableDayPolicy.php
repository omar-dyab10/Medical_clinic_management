<?php

namespace App\Policies;

use App\Models\Available_day;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AvailableDayPolicy
{
    public function create(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'doctor';
    }

    public function update(User $user, Available_day $availableDay): bool
    {
        return $user->role === 'admin' || $user->role === 'doctor';
    }

    public function delete(User $user, Available_day $availableDay): bool
    {
        return $user->role === 'admin' || $user->role === 'doctor';
    }

}
