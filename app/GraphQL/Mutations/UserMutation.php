<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Services\UserService;

final class UserMutation
{

    public $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function createUser($root, array $args)
    {
        return $this->userService->create($args);
    }

    public function updateUser($root, array $args)
    {
        return $this->userService->update($args);
    }

    public function deleteUser($root, array $args)
    {
        return $this->userService->delete($args);
    }

    public function createCredit($root, array $args)
    {
        return $this->userService->update($args);
    }
}
