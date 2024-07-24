<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class UserService
{
    use HasApiTokens;

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $data){

        $credentials = [
            'email' => $data['email'],
            'password'=> $data['password']
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

    public function getAllUsers(){

        return $this->userRepository->all();

    }

    public function getUser(array $data){

        return $this->userRepository->find($data["id"]);

    }

    public function create(array $data){

        return $this->userRepository->create($data);

    }

    public function update(array $data){

        return $this->userRepository->update($data["id"], $data);

    }

    public function delete(array $data){

        return $this->userRepository->delete($data["id"]);

    }

}
