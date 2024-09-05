<?php

namespace App\Facades;

use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Comment createComment(string $comment,User $user,Product $product)
 * 
 * @see \App\Services\CommentService
 */
class CommentFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return CommentServiceInterface::class;
    }
}
