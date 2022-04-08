<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\FirebaseService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    public function index(User $user): UserResource
    {
        return UserResource::make($user->getAll());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return UserResource
     */
    public function show(int $id): UserResource
    {
        return UserResource::make(User::query()->findOrFail($id));
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


        if ($state = $request->only('user_status_id')) {
            if (!$userService->changeUserState($user, $state)) {
                return response([
                    'errors' => ['user_status_id' => 'The user has active orders']
                ]);
            }
        }

        $user->save();

        return response([
                'message' => 'Success',
                'updatedUser' => $user->find($user->getAttribute('id'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param FirebaseService $firebaseService
     * @return Response
     */
    public function destroy(User $user, FirebaseService $firebaseService): Response
    {
        try {
            $firebaseService->deleteUser($user);
        } catch (AuthException|FirebaseException $e) {
            return response($e, ResponseAlias::HTTP_FORBIDDEN);
        }
        $user->setAttribute('is_deleted', true);
        $user->save();
        return response(['message' => 'Success']);
    }
}
