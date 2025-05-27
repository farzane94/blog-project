<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function updateProfileImage(User $user, string $path): User
    {
        $user->update(['profile_image' => $path]);
        return $user;
    }

    public function getUsersRankedByPostViews()
    {
        return User::with('posts.views')
            ->get()
            ->map(function ($user) {
                $user->total_views = $user->posts->sum(fn($post) => $post->views->count());
                return $user;
            })
            ->sortByDesc('total_views')
            ->values();

    }
}
