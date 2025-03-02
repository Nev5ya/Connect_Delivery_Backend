<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return User
     */
    public function index(User $user): User
    {
        return $user->find(auth()->user()->getAuthIdentifier());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
        $user = auth()->user();

        $user
            ->fill($request->all())
            ->syncChanges()
            ->save();

        return response([
            'message' => 'User updated',
            'updatedUser' => $user->find($user->getAttribute('id'))
        ], 200);
    }

    /**
     * @return string[]
     */
    #[ArrayShape([
        'password' => "string",
        'password_confirmation' => "string"
    ])]
    public function passwordRules(): array
    {
        return [
            'password' => 'required|confirmed|string|min:6',
            'password_confirmation' => 'required|string|min:6'
        ];
    }

    /**
     * @param User $user
     * @return string[]
     */
    #[ArrayShape(['email' => "string"])]
    public function profileRules(User $user): array
    {
        return [
            'email' => 'required|unique:users,email,' . $user->id,
        ];
    }
}
