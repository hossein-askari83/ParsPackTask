<?php

namespace App\Services\Interfaces;

use App\Entities\User;

interface UserServiceInterface
{
    /**
     * Create a user with the given username and password
     *
     * @param string $username
     * @param string $password
     * @return User
     */
    public function createUser(string $username, string $password): User;

    /**
     * Check user credentials by username and password and returns user if credentials was matched
     *
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function getUserByCredentials(string $username, string $password): ?User;

    /**
     * Remove a user by username
     *
     * @param string $username
     * @return void
     */
    public function removeUserByUsername(string $username): void;
}
