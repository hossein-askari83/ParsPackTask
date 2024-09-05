<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Facades\UserFacade;
use App\Http\Requests\LoginRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthController
 *
 * Handles user authentication and registration.
 */
class AuthController extends Controller
{
    /**
     * @api {POST} /register/
     * @apiDescription Register a user
     * @apiBody {username}
     * @apiBody {password}
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user =  UserFacade::createUser($username, $password);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }

    /**
     * @api {POST} /login/
     * @apiDescription Login the user and generate a JWT token
     * @apiBody {username}
     * @apiBody {password}
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = UserFacade::getUserByCredentials($username, $password);
        if (!$user)
            return response()->json(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }
}
