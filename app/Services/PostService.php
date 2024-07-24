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

    public function getAllPosts(){

        return $this->postRepository->all();

    }

    public function getPost(array $data){

        return $this->postRepository->find($data["id"]);

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

    public function update(array $data){

        $post = $this->postRepository->find($data['id']);
        if($post->user_id != auth()->user()->id){
            return [
                'success'=> false,
                'message'=> 'User not allowed to update this post'
            ];
        }
        $post = $this->postRepository->update($data['id'], $data);

        return [
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => $post
        ];

    }

    public function delete(array $data){

        $post = $this->postRepository->find($data['id']);
        if($post->user_id != auth()->user()->id){
            return [
                'success'=> false,
                'message'=> 'User not allowed to delete this post'
            ];
        }
        $this->postRepository->delete($data['id']);

        return [
            'success' => true,
            'message' => 'Post deleted successfully'
        ];

    }
}
