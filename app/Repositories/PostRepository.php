<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    public function __construct(Post $model)
    {
        $this->model = $model;
    }
    
    public function myPosts(){
        return $this->model->where("user_id", auth()->user()->id)->orderBy("created_at")->get();
    }
}
