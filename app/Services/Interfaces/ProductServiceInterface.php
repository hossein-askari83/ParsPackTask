<?php

namespace App\Interfaces;

use App\Entities\Product;

interface ProductServiceInterface
{
    /**
     * Create a user with the given username and password.
     *
     * @param string $username
     * @param string $password
     * @return Product
     */
    public function createProduct(string $name): Product;
}
