<?php

namespace Tests;

use App\Facades\UserFacade;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    /**
     *@var EntityManagerInterface
     */
    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->entityManager = app(EntityManagerInterface::class);
        $this->entityManager->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->entityManager->rollback();
        parent::tearDown();
    }

    protected function getAuthenticatedUser()
    {
        $user = UserFacade::createUser($this->faker->userName(), $this->faker->password());
        return $user;
    }
}
