<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Pre-authorization
     *
     * @param User $current
     * @return bool
     */
    public function before(User $current): bool
    {
        return $current->isAdministrator();
    }
}
