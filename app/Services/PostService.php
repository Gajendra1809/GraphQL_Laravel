<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    public $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create(array $data){

        if(isset($data['file'])){
        $image = $data['file'];
        $data["image_url"] = $image->store('images', 'public');
        }
        
        $data["user_id"] = auth()->user()->id;

        $post = $this->postRepository->create($data);
        return [
            'success' => true,
            'message' => 'Post created successfully',
            'data' => $post
        ];

    }
}
