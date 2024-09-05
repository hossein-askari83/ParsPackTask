<?php

namespace App\Facades;

use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Product createProduct(string $name)
 * @method static void removeProductByName(string $name)
 * @method static Product findProductByName(string $name)
 * @method static array findAllProducts()
 * 
 * @see \App\Services\ProductService
 */
class ProductFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ProductServiceInterface::class;
    }
}
