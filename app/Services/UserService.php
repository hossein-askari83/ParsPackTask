<?php

namespace App\Services;

use App\Entities\User;
use App\Factories\Interfaces\UserFactoryInterface;
use App\Repositories\UserRepository;
use App\Services\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     * @param UserFactoryInterface $userFactory
     */
    public function __construct(
        private readonly UserFactoryInterface $userFactory,
        private readonly UserRepository $userRepository
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

    /**
     * @inheritDoc
     */
    public function findUser(int $id): ?User {
        return $this->userRepository->find($id);
    }
}
