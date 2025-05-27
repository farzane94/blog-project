<?php

namespace App\Http\Controllers\Auth;

use App\Enums\HttpStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register a new user and return access token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "mobile", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="farzane"),
     *             @OA\Property(property="mobile", type="string", example="09197224527"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=27),
     *                     @OA\Property(property="name", type="string", example="farzane"),
     *                     @OA\Property(property="mobile", type="string", example="09197224527"),
     *                     @OA\Property(
     *                         property="profile_image",
     *                         type="string",
     *                         nullable=true,
     *                         example=null
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                     example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
     *                 )
     *             ),
     *             @OA\Property(property="server_time", type="string", example="2025-05-24 17:15:55")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return ApiResponse::success([
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ], HttpStatus::CREATED->value);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login user and return access token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"mobile", "password"},
     *             @OA\Property(property="mobile", type="string", example="09197224527"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *                 @OA\Property(property="token_type", type="string", example="bearer"),
     *                 @OA\Property(property="expires_in", type="integer", example=3600)
     *             ),
     *             @OA\Property(property="server_time", type="string", example="2025-05-24 16:20:55")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return response()->json(['message' => __('messages.auth.unauthorized')], HttpStatus::UNAUTHORIZED->value);
        }

        return ApiResponse::success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ], HttpStatus::OK->value);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => __('messages.auth.logout_success')]);
    }

}
