<?php

namespace App\Observers;

use App\Models\User\User;
use App\Helpers\UserHelper;

class UserObserver
{
    public function created(User $user): void
    {
        // Intentionally empty: the previous implementation generated a random
        // password and emailed it on every user creation, which clobbered
        // self-registration and admin-supplied passwords alike.
        // If an admin "invite with random password" flow is needed,
        // call UserHelper::sendUserCreatedEmail($user) explicitly from there.
    }

    public function updated(User $user): void {}

    public function deleted(User $user): void {}

    public function restored(User $user): void {}

    public function forceDeleted(User $user): void {}
}
