<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Post;


final class PostQuery
{
    public function posts(){

        return Post::all();

    }

    public function post($root, array $args){

        return Post::findorFail($args["id"]);

    }
}
