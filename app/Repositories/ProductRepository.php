<?php

namespace App\Repositories;

use App\Entities\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepository extends BaseEntityRepository
{
    /**
     * ProductRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Product::class);
    }

    /**
     * Find product by name
     * 
     * @param string $name
     * @return Product|null
     */
    public function findByName(string $name): ?Product
    {
        return $this->findOneBy(['name' => $name]);
    }
}
