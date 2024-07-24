<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use Laravel\Passport\HasApiTokens;
use App\Services\UserService;


final class UserQuery
{
    use HasApiTokens;

    public $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function users(){

        return $this->userService->getAllUsers();

    }

    public function user($root, array $args){

        return $this->userService->getUser($args);
    
    }

    public function login($root, array $args){

        return $this->userService->login($args);

    }

    public function logout(){

        return $this->userService->logout();

    }
}
