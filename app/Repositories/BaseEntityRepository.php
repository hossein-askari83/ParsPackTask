<?php

namespace App\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @template T of object
 * @mixin EntityRepository<T>
 * @extends EntityRepository<T>
 */
class BaseEntityRepository extends EntityRepository
{


    /**
     * @param class-string<T> $class
     */
    public function __construct(EntityManagerInterface $em, string $class)
    {
        parent::__construct($em, $em->getClassMetadata($class));
    }


    /**
     * Save and persist entity
     * 
     * @param T $entity
     * @return void
     */
    public function save(object $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * Remove given entity
     * 
     * @param T $entity
     * @return void
     */
    public function remove(object $entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
