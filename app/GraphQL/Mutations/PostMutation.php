<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Services\PostService;

final class PostMutation
{
    
    public $postService;

    public function __construct(PostService $postService){
        $this->postService = $postService;
    }

    public function createPost($root, array $args)
    {
        return $this->postService->create($args);
    }

    public function updatePost($root, array $args)
    {
        return $this->postService->update($args);
    }

    public function deletePost($root, array $args)
    {
        return $this->postService->delete($args);
    }

}
