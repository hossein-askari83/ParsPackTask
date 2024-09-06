<?php

namespace Tests\Feature;

use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function test_get_products()
    {
        $mockedProductService = $this->mock(ProductService::class);

        $expectedProducts = [
            ['id' => 1, 'name' => 'Product A'],
            ['id' => 2, 'name' => 'Product B'],
        ];

        $mockedProductService->shouldReceive('findAllProducts')
            ->once()
            ->andReturn($expectedProducts);

        $token = JWTAuth::fromUser($this->getAuthenticatedUser());

        $response = $this->getJson(route('product.index'), ['Authorization' => "Bearer $token"]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson($expectedProducts);
    }
}
