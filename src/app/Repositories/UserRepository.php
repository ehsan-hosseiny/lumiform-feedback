<?php


namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function find($id)
    {
        return User::find($id);
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function create(string $name,string $email,string $password): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
