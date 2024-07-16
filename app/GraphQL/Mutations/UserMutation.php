<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class UserMutation
{
    /**
     * Creates a new user with the provided name, email, and password.
     *
     * @param mixed $root The root object.
     * @param array $args The arguments for creating the user.
     * @return User The newly created user.
     */
    public function createUser($root, array $args)
    {

        return User::create([
            'name' => $args['name'],
            'email'=> $args['email'],
            'password'=> Hash::make($args['password']),
        ]);
        
    }

    /**
     * Updates a user with the provided data.
     *
     * @param mixed $root The root object.
     * @param array $args An array containing the user's ID and optional name, email, and password.
     * @return \App\Models\User The updated user.
     */
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

    /**
     * Deletes a user with the given ID.
     *
     * @param mixed $root The root object.
     * @param array $args The arguments for the function.
     * @return \App\Models\User The deleted user.
     */
    public function deleteUser($root, array $args)
    {
        $user = User::findOrFail($args['id']);
        $user->delete();

        return $user;
    }
}
