<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Traits\Response;

class PostService
{
    use Response;

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

    public function myPosts(){
        return $this->postRepository->myPosts();
    }

    public function create(array $data){

        try {
            if(isset($data['file'])){
                $image = $data['file'];
                $data["image_url"] = $image->store('images', 'public');
            }
                
            $data["user_id"] = auth()->user()->id;
    
            $post = $this->postRepository->create($data);

            return $this->success($post, 'Post created successfully');

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }

    }

    public function update(array $data){

        try {
            $post = $this->postRepository->find($data['id']);
            if($post->user_id != auth()->user()->id){
                return [
                    'success'=> false,
                    'message'=> 'User not allowed to update this post'
                ];
            }
            $post = $this->postRepository->update($data['id'], $data);

            return $this->success($post, 'Post updated successfully');

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }

    }

    public function delete(array $data){

        try {
            $post = $this->postRepository->find($data['id']);
            if($post->user_id != auth()->user()->id){
            return [
                'success'=> false,
                'message'=> 'User not allowed to delete this post'
            ];
            }
            $this->postRepository->delete($data['id']);

            return $this->success(null, 'Post deleted successfully');
            
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }

    }
}
