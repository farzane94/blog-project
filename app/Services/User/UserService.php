<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function updateProfileImage(User $user, UploadedFile $file): string
    {
        $path = $file->store('profile_images', 'public');

        $this->userRepository->updateProfileImage($user, $path);

        return $path;
    }

    public function me(): User
    {
        return Auth::user();
    }

    public function getUsersRankedByPostViews()
    {
        return $this->userRepository->getUsersRankedByPostViews();
    }
}
