<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Post;

class PostTransformers extends TransformerAbstract
{
    protected $availableIncludes = ['user'];
    public function transform(Post $post) 
    {
        return [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'title' => $post->title,
            'contents' => $post->contents,
        ];
    }

    public function includeUser(Post $post)
    {
        $user = $post->user;

        return $this->item($user, new UserTransformers);
    }
}