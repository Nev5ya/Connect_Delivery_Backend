<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    private string $defaultProfilePhotoPath = '/storage/images/profilePhotos/default-avatar.png';

    /**
     * @param User $user
     * @param array $state
     * @return bool
     */
    public function changeUserState(User $user, array $state): bool
    {
        if ($this->hasUserHaveIncompleteOrders($user)) {
            return $user
                ->setAttribute('user_status_id', $state['user_status_id'])
                ->save();
        }

        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function hasUserHaveIncompleteOrders(User $user): bool
    {
       return $user->order()->get()->where('order_status_id', '<>', 3)->isEmpty();
    }

    /**
     * @param Request $request
     * @return array|array[]
     */
    public function handleProfilePhoto(Request $request): array
    {
        if ( empty($request->files->all()) || !$request->files->has('profilePhoto') ) {
            return [
                'errors' => [
                    'profilePhoto' => 'You need to upload a photo'
                    ]
            ];
        }

        $allowedTypes = ['png', 'jpg', 'jpeg', 'gif'];

        if( !in_array($request->file('profilePhoto')->extension(), $allowedTypes) ) {
            return [
                'errors' => [
                    'profilePhoto' => 'File type must be: ' . join(', ', $allowedTypes)
                ]
            ];
        }

        $path = $request->file('profilePhoto')->store('public/images/profilePhotos');

        $this->setNewUserPhoto($path);

        return [
            'path' => $path
        ];
    }

    /**
     * @param $path
     * @return void
     */
    protected function setNewUserPhoto($path): void
    {
        User::query()
            ->find(auth()->user()->getAuthIdentifier())
            ->setAttribute('photo', str_replace('public', '/storage', $path))
            ->save();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function setDefaultUserPhoto(User $user): mixed
    {
        $user = $user->find(auth()->user()->getAuthIdentifier());
        return $user
            ->setAttribute('photo', $this->defaultProfilePhotoPath)
            ->save();
    }

    /**
     * @param User $target
     * @return bool
     */
    public function checkPermissions(User $target): bool
    {
        $current = auth()->user();

        return $current->isAdministrator()
            || $target->getAuthIdentifier() === $current->getAuthIdentifier();
    }
}
