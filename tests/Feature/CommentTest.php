<?php

namespace Tests\Feature;

use App\Entities\Comment;
use App\Services\CommentService;
use App\Services\ProductService;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function test_store_comment()
    {
        $mockedProductService = $this->mock(ProductService::class);

        $mockedCommentService = $this->mock(CommentService::class);


        $expectedProduct = new \App\Entities\Product();
        $expectedProductName = $this->faker()->word();
        $expectedProduct->setName($expectedProductName);

        $expectedComment = new \App\Entities\Comment();
        $expectedCommentText = $this->faker()->text(10);
        $expectedComment->setComment($expectedCommentText);
        $expectedComment->setProduct($expectedProduct);

        Event::fake();

        $mockedProductService->shouldReceive('findProductByName')
            ->once()
            ->with($expectedProductName)
            ->andReturn($expectedProduct);

        $mockedCommentService->shouldReceive('createComment')
            ->once()
            ->with($expectedCommentText, \Mockery::type(\App\Entities\User::class), $expectedProduct)
            ->andReturn($expectedComment);

        $token = JWTAuth::fromUser($this->getAuthenticatedUser());

        $response = $this->postJson(route('comment.store'), [
            'comment' => $expectedCommentText,
            'product' => $expectedProductName
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'comment' => $expectedCommentText,
            ]);
    }

    /**
     * @test
     * @return void
     */
    public function test_store_more_than_two_comment_on_single_product()
    {
        $mockedProductService = $this->mock(ProductService::class);

        $fakeUser = $this->getAuthenticatedUser();

        $expectedProduct = new \App\Entities\Product();
        $expectedProductName = $this->faker()->word();
        $expectedProduct->setName($expectedProductName);

        $fakeComment = $this->generateFakeComment();
        $secondFakeComment = $this->generateFakeComment();

        $comments = new ArrayCollection([$fakeComment, $secondFakeComment]);
        $expectedProduct->setComments($comments);
        $fakeUser->setComments($comments);

        $expectedComment = new Comment();
        $expectedCommentText = $this->faker()->text(10);
        $expectedComment->setComment($expectedCommentText);
        $expectedComment->setProduct($expectedProduct);

        Event::fake();

        $mockedProductService->shouldReceive('findProductByName')
            ->once()
            ->with($expectedProductName)
            ->andReturn($expectedProduct);

        $token = JWTAuth::fromUser($fakeUser);

        $response = $this->postJson(route('comment.store'), [
            'comment' => $expectedCommentText,
            'product' => $expectedProductName
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Generate a fake comment
     * 
     * @return Comment
     */
    protected function generateFakeComment(): Comment
    {
        $fakeComment = new Comment();
        $fakeCommentText = $this->faker()->text(10);
        $fakeComment->setComment($fakeCommentText);

        return $fakeComment;
    }
}
