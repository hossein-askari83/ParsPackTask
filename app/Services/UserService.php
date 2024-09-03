<?php

namespace App\Services;

use App\Entities\User;
use App\Interfaces\Factories\UserFactoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private readonly UserFactoryInterface $userFactory,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function createUser(string $username, string $password): User
    {
        $user = $this->userFactory->create($username, $password);

        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getUserByCredentials(string $username, string $password): ?User
    {
        $user = $this->userRepository->findByUsername($username);

        if (!$user) return null;

        $salt = $user->getSalt();
        $hashedPassword = hash('sha256', $salt . $password);

        return $hashedPassword === $user->getPassword() ? $user : null;
    }

    /**
     * @inheritDoc
     */
    public function removeUserByUsername(string $username): void
    {
        $user = $this->userRepository->findByUsername($username);

        if ($user) $this->userRepository->remove($user);
    }
}
