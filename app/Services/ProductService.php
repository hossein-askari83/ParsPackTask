<?php

namespace App\Services;

use App\Entities\Product;
use App\Services\Interfaces\ProductServiceInterface;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;

class ProductService implements ProductServiceInterface
{

    /**
     * UserService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function createProduct(string $name): Product
    {
        $product = new Product();
        $product->setName($name);

        $this->productRepository->save($product);

        return $product;
    }

    /**
     * @inheritDoc
     */
    public function removeProductByName(string $name): void
    {
        $product = $this->productRepository->findByName($name);

        if ($product) $this->productRepository->remove($product);
    }

    /**
     * @inheritDoc
     */
    public function findProductByName(string $name): ?Product
    {
        return  $this->productRepository->findByName($name);
    }

    /**
     * @inheritDoc
     */
    public function findAllProducts(): array
    {
        return $this->productRepository->findAll();
    }
}
