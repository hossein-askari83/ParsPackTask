<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Entities\User;
use App\Facades\UserFacade;
use Doctrine\ORM\EntityManagerInterface;
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
     * Register a new user.
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
     * Login the user and generate a JWT token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
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
