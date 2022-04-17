<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @throws FirebaseException
     * @throws AuthException
     */
    public function register(Request $request, FirebaseService $firebaseService): Response|Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6']
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->getMessages()
            ], Response::HTTP_BAD_REQUEST);
        }

        $firebaseService->createUser($request->only('email', 'password'));

        $user = User::query()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $user->fill($request->except('password'))->save();

        return response([
            'message' => 'Success',
            'newUser' => $user->find($user->getAttribute('id'))
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request): Response|Application|ResponseFactory
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'errors' => 'Invalid credentials'
            ], Response::HTTP_FORBIDDEN);
        }

        $user = Auth::user();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response([
            'message' => 'Success',
            'currentUser' => $user->find(Auth::user()->getAuthIdentifier()),
            'auth-token' => $token,
        ]);
}

    public function user(User $user): Model|Collection|Builder|array|null
    {
        return $user->find(Auth::user()->getAuthIdentifier());
    }

    public function logout(): Response|Application|ResponseFactory
    {
        $user = auth()->user();

        $user->tokens()->where(
            'id', $user->currentAccessToken()->getAttribute('id')
        )->delete();

        return response([
            'message' => 'Success'
        ]);
    }
}
