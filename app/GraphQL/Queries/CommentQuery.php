<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Services\CommentService;

final class CommentQuery
{

    public $commentService;

    public function __construct(CommentService $commentService){
        $this->commentService = $commentService;
    }

    public function comments(){
        return $this->commentService->getAll();
    }


    public function commentsByPostId($root, array $args){
        return $this->commentService->commentsByPostId($args);
    }
}
