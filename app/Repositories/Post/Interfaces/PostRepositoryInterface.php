<?php

namespace App\Repositories\Post\Interfaces;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function getUserPostsWithViews(int $userId, string $ip, int $perPage = 10);

    public function show(Post $post, ?string $ip);
}
