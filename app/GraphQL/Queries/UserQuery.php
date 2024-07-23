<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Log;


final class UserQuery
{
    use HasApiTokens;

    /**
     * Retrieves all users from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection|User[] The collection of all users.
     */
    public function users(){

        return User::all();

    }

    /**
     * Retrieves a specific user based on the provided ID.
     *
     * @param mixed $root The root object.
     * @param array $args An array containing the user's ID.
     * @return \App\Models\User The user with the given ID.
     */
    public function user($root, array $args){

        $user = User::find($args['id']);

        if(!$user){
            return [
                'success' => false,
                'message' => 'User not found!'
            ];
        }

        return $user;
    
    }

    /**
     * Logs in a user with the provided credentials.
     *
     * @param mixed $root The root object.
     * @param array $args An array containing the user's email and password.
     * @return array The result of the login operation including success status, message, access token, and token type.
     */
    public function login($root, array $args){

        $credentials = [
            'email' => $args['email'],
            'password'=> $args['password']
        ];
 
        if (!Auth::attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'Wrong Credentials!'
            ];
        }

        $user = Auth::user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();

        return [
            'success' => true,
            'message'=> 'Login Successful',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
        ];

    }

    /**
     * Logs out the user by revoking the user's token.
     *
     * @return array The result of the logout operation including success status and a message.
     */
    public function logout(){

        $user = auth()->user();

        $user->token()->revoke();

        return [
            'success' => true,
            'message' => 'Logout Successful'
        ];
    }
}
