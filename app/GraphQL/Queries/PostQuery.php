<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Services\PostService;


final class PostQuery
{
    
    public function __construct(
        protected PostService $postService
    ){
    }

    public function posts(){

        return $this->postService->getAllPosts();

    }

    public function post($root, array $args){

        return $this->postService->getPost($args);

    }

    public function myPosts(){
        return $this->postService->myPosts();
    }
}
