<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class UserMutation
{
    public function createUser($root, array $args)
    {

        return User::create([
            'name' => $args['name'],
            'email'=> $args['email'],
            'password'=> Hash::make($args['password']),
        ]);
        
    }

    public function updateUser($root, array $args)
    {
        $user = User::findOrFail($args['id']);
        if (isset($args['name'])) {
            $user->name = $args['name'];
        }
        if (isset($args['email'])) {
            $user->email = $args['email'];
        }
        if (isset($args['password'])) {
            $user->password = Hash::make($args['password']);
        }
        $user->save();

        return $user;
    }

    public function deleteUser($root, array $args)
    {
        $user = User::findOrFail($args['id']);
        $user->delete();

        return $user;
    }
}
