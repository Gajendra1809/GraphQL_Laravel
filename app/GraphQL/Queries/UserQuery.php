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

    public function logout(){

        $user = auth()->user();

        $user->token()->revoke();

        return [
            'success' => true,
            'message' => 'Logout Successful'
        ];
    }
}
