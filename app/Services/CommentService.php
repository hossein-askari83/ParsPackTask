<?php

namespace App\Services;

use App\Entities\Comment;
use App\Entities\Product;
use App\Entities\User;
use App\Repositories\CommentRepository;
use App\Services\Interfaces\CommentServiceInterface;

class CommentService implements CommentServiceInterface
{

    /**
     * CommentService constructor.
     *
     * @param CommentRepository $commentRepository
     */
    public function __construct(
        private readonly CommentRepository $commentRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function createComment(string $comment, User $user, Product $product): Comment
    {
        $commentObject = new Comment();
        $commentObject->setComment($comment);
        $commentObject->setUser($user);
        $commentObject->setProduct($product);

        $this->commentRepository->save($commentObject);
        return $commentObject;
    }
}
