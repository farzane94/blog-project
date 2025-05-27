<?php

namespace App\Http\Controllers\Post;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Post\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    )
    {
    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get authenticated user's posts",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Hello world"),
     *                 @OA\Property(
     *                     property="body",
     *                     type="string",
     *                     example="Lorem Ipsum is simply dummy text of the printing and typesetting industry..."
     *                 ),
     *                 @OA\Property(property="views_count", type="integer", example=10),
     *                 @OA\Property(
     *                     property="author",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Sara"),
     *                     @OA\Property(
     *                         property="profile_image",
     *                         type="string",
     *                         nullable=true,
     *                         example="http://localhost/storage/profile/sara.jpg"
     *                     )
     *                 )
     *             )),
     *             @OA\Property(property="server_time", type="string", example="2025-05-24 12:34:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */

    public function index(Request $request)
    {
        $user = auth()->user();
        $posts = $this->postRepository->getUserPostsWithViews($user->id, $request->ip());

        return ApiResponse::success(PostResource::collection($posts));
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a single post by ID",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post found successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Qui qui ea dolores sint."),
     *                 @OA\Property(property="body", type="string", example="Labore et hic dolorum..."),
     *                 @OA\Property(property="views_count", type="integer", example=2),
     *                 @OA\Property(property="author", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Tara Pagac"),
     *                     @OA\Property(
     *                         property="profile_image",
     *                         type="string",
     *                         nullable=true,
     *                         example="http://localhost:8000/storage/profile_images/ukzz2WRY2zouwJd72zFJJzLNBoLyww1jKDkxawll.jpg"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="server_time", type="string", example="2025-05-24 16:35:01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */
    public function show(Post $post, Request $request)
    {
        return ApiResponse::success(new PostResource($this->postRepository->show($post, $request->ip())));
    }


}

