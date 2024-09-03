<?php

namespace App\Facades;

use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static User createUser(string $username, string $password)
 * @method static ?User getUserByCredentials(string $username, string $password)
 * @method static void removeUserByUsername(string $username)
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
}
