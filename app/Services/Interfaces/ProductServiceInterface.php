<?php

namespace App\Services\Interfaces;

use App\Entities\Product;

interface ProductServiceInterface
{
    /**
     * Create a product with the given name
     *
     * @param string $name
     * @return Product
     */
    public function createProduct(string $name): Product;

    /**
     * Remove a product by the given name
     *
     * @param string $name
     * @return void
     */
    public function removeProductByName(string $name): void;

    /**
     * Find a product by the given name
     *
     * @param string $name
     * @return Product|null
     */
    public function findProductByName(string $name): ?Product;

    /**
     * Find all products
     * 
     * @return array
     */
    public function findAllProducts(): array;
}
