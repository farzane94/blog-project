<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\Post\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{

    public function getUserPostsWithViews(int $userId, string $ip, int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        $posts = Post::with(['user', 'views'])
            ->where('user_id', $userId)
            ->paginate($perPage);

        foreach ($posts as $post) {
            $post->recordUniqueView($ip);
        }

        return $posts;
    }

    public function show(Post $post, ?string $ip)
    {
        $post->recordUniqueView($ip);
        return $post;
    }
}
