<?php

namespace App\Facades;

use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Facade;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @method static User createUser(string $username, string $password)
 * @method static ?User getUserByCredentials(string $username, string $password)
 * @method static void removeUserByUsername(string $username)
 * @method static ?User findUser(int $id)
 *
 * @see \App\Services\UserService
 */
class UserFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return UserServiceInterface::class;
    }

    /**
     * Convert the given token into related user id
     * 
     * @return int
     */
    public static function parseTokenToUserId(): int
    {
        $token = JWTAuth::parseToken();
        $payload = JWTAuth::getPayload($token);
        return $payload->get('sub');
    }
}
