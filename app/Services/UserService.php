<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use App\Traits\Response;

class UserService
{
    
    use HasApiTokens, Response;

    public function __construct(
        protected UserRepository $userRepository
    ){
    }

    public function login(array $data){

        $credentials = [
            'email' => $data['email'],
            'password'=> $data['password']
        ];
 
        if (!Auth::attempt($credentials)) {
            return $this->fail("Credentials do not match");
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

        return $this->success(null, 'Logout Successful');

    }

    public function getAllUsers(){

        return $this->userRepository->all();

    }

    public function getUser(array $data){

        return $this->userRepository->find($data["id"]);

    }

    public function create(array $data){

        try {
            
            $data["credit"] = config("credit.default_credit");
            $user = $this->userRepository->create($data);
        
            return $this->success($user, 'User created successfully');

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }

    }

    public function update(array $data){

        try {

            if(isset($data['credit'])){
                $user = $this->userRepository->find($data['id']);
                $data["credit"] = $user->credit + $data["credit"];
            }
            
            $user = $this->userRepository->update($data["id"], $data);

            return $this->success($user, 'User updated successfully');

        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }

    }

    public function delete(array $data){

        try {
            $this->userRepository->delete($data["id"]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }

    }

}
