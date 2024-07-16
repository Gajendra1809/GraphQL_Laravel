<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Post;


final class PostQuery
{
    /**
     * Retrieves all posts.
     *
     * @return mixed
     */
    public function posts(){

        return Post::all();

    }

    /**
     * Retrieves a post by its ID.
     *
     * @param mixed $root The root object.
     * @param array $args An array containing the ID of the post.
     * @return \App\Models\Post The post with the given ID.
     */
    public function post($root, array $args){

        return Post::findorFail($args["id"]);

    }
}
