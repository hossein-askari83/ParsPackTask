<?php

namespace Tests\Feature;

use App\Entities\User;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function test_register_user()
    {
        $mockedUserService = $this->mock(UserService::class);

        $expectedUser = new User();
        $fakeUserName = $this->faker()->userName();
        $expectedUser->setUsername($fakeUserName);

        $expectedToken = $this->faker()->text(10);

        $mockedUserService->shouldReceive('createUser')
            ->once()
            ->with($fakeUserName, 'password')
            ->andReturn($expectedUser);

        JWTAuth::shouldReceive('fromUser')
            ->once()
            ->andReturn($expectedToken);

        $response = $this->postJson(route('register'), [
            'username' => $fakeUserName,
            'password' => 'password'
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => true,
                'token' => $expectedToken,
            ]);
    }

    /**
     * @test
     * @return void
     */
    public function test_logging_user()
    {

        $mockedUserService = $this->mock(UserService::class);

        $expectedUser = new User();
        $fakeUserName = $this->faker()->userName();
        $expectedUser->setUsername($fakeUserName);
        $expectedToken = $this->faker()->text(10);

        $mockedUserService->shouldReceive('getUserByCredentials')
            ->once()
            ->with($fakeUserName, 'password')
            ->andReturn($expectedUser);

        JWTAuth::shouldReceive('fromUser')
            ->once()
            ->andReturn($expectedToken);

        $response = $this->postJson(route('login'), [
            'username' => $fakeUserName,
            'password' => 'password'
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => true,
                'token' => $expectedToken,
            ]);
    }


    /**
     * @test
     * @return void
     */
    public function test_logging_user_with_invalid_credentials()
    {

        $mockedUserService = $this->mock(UserService::class);

        $fakeUserName = $this->faker()->userName();

        $expectedToken = $this->faker()->text(10);

        $mockedUserService->shouldReceive('getUserByCredentials')
            ->once()
            ->with($fakeUserName, 'password')
            ->andReturn(null);


        $response = $this->postJson(route('login'), [
            'username' => $fakeUserName,
            'password' => 'password'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
