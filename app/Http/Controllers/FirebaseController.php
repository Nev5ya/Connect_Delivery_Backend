<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Factory;

class FirebaseController extends Controller
{

    private Database $database;
    protected string $dbname;

    public function __construct()
    {
        $this->database = FirebaseService::connect();
        $this->dbname = 'users';
    }

    public function index()
    {
        $users = [];
        for ($i = 1; $i < 100; $i++) {//6.5sec for 100
            $users[$i] = [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123'),
                'role_id' => 2,
                'user_status_id' => 2,
                'remember_token' => Str::random(10),
                'created_at' => date(now()),
            ];
        }
        dd($this->database->getReference($this->dbname)
            ->set($users));

        return response()->json($this->database->getReference('test/blogs')->getValue());
    }

    public function create()
    {
        $request = ['title' => '123123', 'content' => '421'];
        $this->database
            ->getReference('test/blogs/' . $request['title'])
            ->set([
                'title' => $request['title'] ,
                'content' => $request['content']
            ]);

        return response()->json('blog has been created');
    }

    public function firebaseInsert(array $data): bool
    {
        if (empty($data) || !isset($data)) { return FALSE; }
        foreach ($data as $key => $value){
            $this->database->getReference()->getChild($this->dbname)->getChild($key)->set($value);
        }
        return TRUE;
    }

    public function delete(Request $request)
    {
        $request = ['title' => '123123', 'content' => '421'];
        $this->database
            ->getReference('Alex' . $request['title'])
            ->remove();

        return response()->json('blog has been deleted');
    }
}
