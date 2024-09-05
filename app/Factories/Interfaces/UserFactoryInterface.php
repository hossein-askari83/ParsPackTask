<?php

namespace App\Factories\Interfaces;

use App\Entities\User;

interface UserFactoryInterface
{
    /**
     * Create a new User instance.
     *
     * @param string $username
     * @param string $password
     * @return User
     */
    public function create(string $username, string $password): User;
}
