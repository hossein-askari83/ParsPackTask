<?php

namespace App\Services\Interfaces;

use App\Entities\Comment;
use App\Entities\Product;
use App\Entities\User;

interface CommentServiceInterface
{
    /**
     * Create a new comment with the given data
     * 
     * @param string $comment
     * @param User $user
     * @param Product $product
     * 
     * @return Comment
     */
    public function createComment(string $comment, User $user, Product $product): Comment;
}
