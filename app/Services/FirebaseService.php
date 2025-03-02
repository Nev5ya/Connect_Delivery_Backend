<?php

namespace App\Services;

use App\Models\User;
use Kreait\Firebase\Auth\SignInResult;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Factory;

class FirebaseService
{
    protected Factory $firebase;

    public function __construct()
    {
        $this->firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));
    }

    /**
     * @return Database
     */
    public function getDb(): Database
    {
        return $this->firebase->createDatabase();
    }

    /**
     * @return Auth
     */
    public function getAuth(): Auth
    {
        return $this->firebase->createAuth();
    }

    /**
     * @throws FirebaseException
     * @throws AuthException
     */
    public function createUser(array $data): void
    {
        $this->getAuth()->createUserWithEmailAndPassword($data['email'], $data['password']);
    }

    /**
     * @throws AuthException
     * @throws FirebaseException
     */
    public function deleteUser(User $user): void
    {
        $firebaseUser = $this->getAuth()->getUserByEmail($user->getEmailForVerification());
        $this->getAuth()->deleteUser($firebaseUser->uid);
    }

    /**
     * @throws FirebaseException
     * @throws AuthException
     */
    public function getUserByEmail(string $email): UserRecord
    {
        return $this->getAuth()->getUserByEmail($email);
    }
}
