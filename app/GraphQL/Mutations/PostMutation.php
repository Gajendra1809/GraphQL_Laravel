<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Post;
use App\Services\PostService;

final class PostMutation
{
    
    public $postService;

    public function __construct(PostService $postService){
        $this->postService = $postService;
    }

    public function createPost($root, array $args)
    {
        return $this->postService->create($args);
    }

    /**
     * Updates a post with the provided arguments.
     *
     * @param mixed $root The root object.
     * @param array $args The arguments for the update.
     * @return array The result of the post update operation.
     */
    public function updatePost($root, array $args)
    {
        $post = Post::findOrFail($args['id']);
        if($post->user_id != auth()->user()->id){
            return [
                'success' => false,
                'message' => 'User not authorized to update this post'
            ];
        }
        
        if (isset($args['title'])) {
            $post->title = $args['title'];
        }
        if (isset($args['content'])) {
            $post->content = $args['content'];
        }
        $post->save();

        return [
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => $post
        ];
    }

    /**
     * Deletes a post based on the provided arguments.
     *
     * @param mixed $root The root object.
     * @param array $args The arguments for the deletion.
     * @return array The result of the post deletion operation.
     */
    public function deletePost($root, array $args)
    {
        $post = Post::findOrFail($args['id']);
        if($post->user_id != auth()->user()->id){
            return [
                'success' => false,
                'message' => 'User not authorized to delete this post'
            ];
        }
        $post->delete();

        return [
            'success' => true,
            'message' => 'Post deleted successfully'
        ];
    }

}
