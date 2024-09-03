<?php

namespace App\Repositories\Interfaces;

use App\Entities\User;

interface UserRepositoryInterface
{
    /**
     * Find a user by username.
     *
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username): ?User;

    /**
     * Save a user to the database.
     *
     * @param User $user
     * @return void
     */
    public function save(User $user): void;

    /**
     * Remove a user from the database.
     *
     * @param User $user
     * @return void
     */
    public function remove(User $user): void;
}
