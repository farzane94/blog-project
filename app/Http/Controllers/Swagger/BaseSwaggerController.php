<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Blog Project API",
 *     description="API documentation for the blog system.",
 *     @OA\Contact(
 *         email="farzane.rahmani2@gmail.com"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */

class BaseSwaggerController extends Controller
{
    //
}
