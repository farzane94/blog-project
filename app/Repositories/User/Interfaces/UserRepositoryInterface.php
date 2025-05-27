<?php

namespace App\Repositories\User\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function updateProfileImage(User $user, string $path): User;

    public function getUsersRankedByPostViews();

}
