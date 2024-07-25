<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Auth;

class CommentService
{

    public $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAll(){
        return $this->commentRepository->all();
    }

    public function commentsByPostId($data){
        return $this->commentRepository->getByPostId($data["id"]);
    }

    public function create($data){
        $data["user_id"] = Auth::user()->id;
        return $this->commentRepository->create($data);
    }

    public function delete($data){
        return $this->commentRepository->delete($data["id"]);
    }

}
