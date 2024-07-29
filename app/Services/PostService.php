<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Traits\Response;

class PostService
{
    use Response;

    public $postRepository;
    public $userRepository;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
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

            if(auth()->user()->credit < config("credit.min_credit")){
                return $this->fail("Not enough credit! Bye more credits to post");
            }

            if(isset($data['file'])){
                $image = $data['file'];
                $data["image_url"] = $image->store('images', 'public');
            }

            $data["user_id"] = auth()->user()->id;
    
            $post = $this->postRepository->create($data);

            $credits = auth()->user()->credit;
            $credits = $credits - config("credit.min_credit");
            $arr['credit'] = $credits;

            $this->userRepository->update(auth()->user()->id, $arr);

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
