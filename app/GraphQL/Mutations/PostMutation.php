<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Post;

final class PostMutation
{
    public function createPost($root, array $args)
    {
        $post = new Post();
        $post->title = $args['title'];
        $post->content = $args['content'];
        $post->user_id = $args['user_id'];
        $post->save();

        return $post;
    }

    public function updatePost($root, array $args)
    {
        $post = Post::findOrFail($args['id']);
        if (isset($args['title'])) {
            $post->title = $args['title'];
        }
        if (isset($args['content'])) {
            $post->content = $args['content'];
        }
        $post->save();

        return $post;
    }

    public function deletePost($root, array $args)
    {
        $post = Post::findOrFail($args['id']);
        $post->delete();

        return $post;
    }

}
