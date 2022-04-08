<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function changeUserState(User $user, array $state): bool
    {
        if ($this->hasUserHaveIncompleteOrders($user)) {
            return $user
                ->setAttribute('user_status_id', $state['user_status_id'])
                ->save();
        }

        return false;
    }

    protected function hasUserHaveIncompleteOrders(User $user): bool
    {
       return $user->order()->get()->where('order_status_id', '<>', 3)->isEmpty();
    }
}
