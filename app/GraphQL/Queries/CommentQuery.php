<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Services\CommentService;

final class CommentQuery
{

    public function __construct(
        protected CommentService $commentService
    ){
    }

    public function comments(){
        return $this->commentService->getAll();
    }


    public function commentsByPostId($root, array $args){
        return $this->commentService->commentsByPostId($args);
    }
}
