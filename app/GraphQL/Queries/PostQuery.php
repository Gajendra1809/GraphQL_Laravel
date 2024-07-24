<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Services\PostService;


final class PostQuery
{
    public $postService;

    public function __construct(PostService $postService){
        $this->postService = $postService;
    }

    public function posts(){

        return $this->postService->getAllPosts();

    }

    public function post($root, array $args){

        return $this->postService->getPost($args);

    }
}
