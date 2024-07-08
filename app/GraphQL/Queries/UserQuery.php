<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;


final class UserQuery
{
    use HasApiTokens;

    public function users(){

        return User::all();

    }

    public function user($root, array $args){

        return User::find($args['id']);
    
    }

    public function login($root, array $args){

        $credentials = [
            'email' => $args['email'],
            'password'=> $args['password']
        ];
 
        if (!Auth::attempt($credentials)) {
            throw new \Exception('Invalid credentials');
        }

        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();

        return [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
        ];

    }
}
