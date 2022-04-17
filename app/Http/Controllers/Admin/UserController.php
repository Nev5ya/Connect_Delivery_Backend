<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\FirebaseService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    /**
     * @param User $user
     * @return UserResource
     */
    public function index(User $user): UserResource
    {
        return UserResource::make($user->getAll());
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
//        $firebaseService->getUserByEmail($user->getEmailForVerification());
        return UserResource::make(
            $user->find($user->getAttribute('id'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param UserService $userService
     * @return Response
     */
    public function update(Request $request, User $user, UserService $userService): Response
    {
        $user
            ->fill($request->all())
            ->syncChanges();


        if ( $state = $request->only('user_status_id') ) {
            if ( !$userService->changeUserState($user, $state) ) {
                return response([
                    'errors' => ['user_status_id' => 'The user has active orders']
                ], ResponseAlias::HTTP_CONFLICT);
            }
        }

        $user->save();

        return response([
            'message' => 'User updated',
            'updatedUser' => $user->find($user->getAttribute('id'))
        ], ResponseAlias::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param UserService $userService
     * @param FirebaseService $firebaseService
     * @return Response
     */
    public function destroy(User $user, UserService $userService, FirebaseService $firebaseService): Response
    {
        if ( !$userService->hasUserHaveIncompleteOrders($user) ) {
            return response([
                'errors' => [
                    'user_status_id' => 'The user has active orders'
                ]
            ], ResponseAlias::HTTP_CONFLICT);
        }

        try {
            $firebaseService->deleteUser($user);
        } catch (AuthException|FirebaseException $e) {
            return response($e, ResponseAlias::HTTP_FORBIDDEN);
        }

        $user->setAttribute('is_deleted', true);
        $user->save();

        return response([
            'message' => 'The user was deleted'
        ]);
    }

    public function uploadPhoto(Request $request, UserService $userService): Response|Application|ResponseFactory
    {
        $message = $userService->handleProfilePhoto($request);

        if (isset($message['errors'])) {
            return response($message, ResponseAlias::HTTP_CONFLICT);
        }

        return response([
            'message' => 'File uploaded'
        ]);
    }

    public function destroyPhoto(User $user, UserService $userService): Response|Application|ResponseFactory
    {
        $userService->setUserPhotoToDefault($user);
        return response([
            'message' => 'The photo was restored to default'
        ]);
    }
}
