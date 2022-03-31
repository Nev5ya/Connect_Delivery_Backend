<?php

namespace App\Services;

use Kreait\Firebase\Auth\SignInResult;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Database;
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

    public function getDb(): Database
    {
        return $this->firebase->createDatabase();
    }

    public function auth(): Auth
    {
        return $this->firebase->createAuth();
    }
}
