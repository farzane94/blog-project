<?php

namespace App\Http\Controllers\User;

use App\Enums\HttpStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UploadProfileImageRequest;
use App\Http\Resources\UserRankingResource;
use App\Http\Resources\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    /**
     * @OA\Post(
     *     path="/api/profile/image",
     *     summary="Upload user's profile image",
     *     tags={"Profile"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"image"},
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                     description="Image file to upload"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Image uploaded successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="message", type="string", example="Profile image updated successfully."),
     *                 @OA\Property(
     *                     property="profile_image_url",
     *                     type="string",
     *                     example="http://localhost:8000/storage/profile_images/vl05yIorRvteG9ROPKBkYlbfP5vP851c0nwuF3hf.jpg"
     *                 )
     *             ),
     *             @OA\Property(property="server_time", type="string", example="2025-05-24 16:51:01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */

    public function uploadProfileImage(UploadProfileImageRequest $request)
    {
        $user = auth()->user();

        $path = $this->userService->updateProfileImage($user, $request->file('image'));

        return ApiResponse::success([
            'message' => __('messages.profile.image_uploaded'),
            'profile_image_url' => asset('storage/' . $path),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/users/rankings",
     *     summary="Get list of top ranked users by total post views",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with ranked users",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="users", type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Tara Pagac"),
     *                         @OA\Property(
     *                             property="profile_image",
     *                             type="string",
     *                             example="http://localhost:8000/storage/profile_images/ukzz2WRY2zouwJd72zFJJzLNBoLyww1jKDkxawll.jpg"
     *                         ),
     *                         @OA\Property(property="total_views", type="integer", example=4)
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="server_time", type="string", example="2025-05-24 17:31:01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Unexpected server error"
     *     )
     * )
     */
    public function rankings()
    {
        return ApiResponse::success([
            'users' => UserRankingResource::collection($this->userService->getUsersRankedByPostViews()),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/profile/me",
     *     summary="Get the currently authenticated user's profile",
     *     tags={"Profile"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User profile retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=26),
     *                     @OA\Property(property="name", type="string", example="farzane"),
     *                     @OA\Property(property="mobile", type="string", example="09197224528"),
     *                     @OA\Property(
     *                         property="profile_image",
     *                         type="string",
     *                         example="http://localhost:8000/storage/profile_images/ZbApL64uXQ5LNkhqA9C3ZIyQwmVTn2EAe5KMKafy.jpg"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="server_time", type="string", example="2025-05-24 17:18:46")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */

    public function me(): JsonResponse
    {
        return ApiResponse::success([
            new UserResource($this->userService->me())
        ], HttpStatus::OK->value);
    }


}

