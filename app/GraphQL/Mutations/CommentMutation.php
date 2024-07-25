<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Services\CommentService;

final class CommentMutation
{
 
    public $commentService;

    public function __construct(CommentService $commentService){
        $this->commentService = $commentService;
    }

    public function create($root, array $args){
        return $this->commentService->create($args);
    }

    public function delete($root, array $args){
        return $this->commentService->delete($args);
    }

}
