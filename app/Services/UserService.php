<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    private string $defaultProfilePhotoPath = '/storage/images/profilePhotos/default-avatar.png';

    public function changeUserState(User $user, array $state): bool
    {
        if ($this->hasUserHaveIncompleteOrders($user)) {
            return $user
                ->setAttribute('user_status_id', $state['user_status_id'])
                ->save();
        }

        return false;
    }

    public function hasUserHaveIncompleteOrders(User $user): bool
    {
       return $user->order()->get()->where('order_status_id', '<>', 3)->isEmpty();
    }

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

    protected function setNewUserPhoto($path): void
    {
        User::query()
            ->find(auth()->user()->getAuthIdentifier())
            ->setAttribute('photo', str_replace('public', '/storage', $path))
            ->save();
    }

    public function setUserPhotoToDefault(User $user)
    {
        $user = $user->find(auth()->user()->getAuthIdentifier());
        return $user
            ->setAttribute('photo', $this->defaultProfilePhotoPath)
            ->save();
    }
}
