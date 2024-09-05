<?php

namespace App\Repositories;

use App\Entities\Comment;
use Doctrine\ORM\EntityManagerInterface;

class CommentRepository extends BaseEntityRepository
{
    /**
     * CommentRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Comment::class);
    }
}
