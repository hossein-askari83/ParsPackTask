<?php

namespace App\Factories;

use App\Entities\User;
use App\Factories\Interfaces\UserFactoryInterface;

class UserFactory implements UserFactoryInterface
{
    /**
     * Create a new User instance with a salted and hashed password.
     *
     * @param string $username
     * @param string $password
     * @return User
     */
    public function create(string $username, string $password): User
    {
        $salt = bin2hex(random_bytes(16));

        $hashedPassword = hash('sha256', $salt . $password);

        $user = new User();
        $user->setUsername($username);
        $user->setSalt($salt);
        $user->setPassword($hashedPassword);

        return $user;
    }
}
