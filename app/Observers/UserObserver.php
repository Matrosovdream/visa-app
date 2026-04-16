<?php

namespace App\Observers;

use App\Models\User\User;
use App\Helpers\UserHelper;

class UserObserver
{
    public function created(User $user): void
    {
        UserHelper::sendUserCreatedEmail($user);
    }

    public function updated(User $user): void {}

    public function deleted(User $user): void {}

    public function restored(User $user): void {}

    public function forceDeleted(User $user): void {}
}
