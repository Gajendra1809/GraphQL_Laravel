<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
