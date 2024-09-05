<?php

namespace Database\Seeders;

use App\Entities\User;
use App\Facades\ProductFacade;
use App\Facades\UserFacade;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seedParspackUser();
        $this->seedDefaultProducts();
    }

    /**
     * Create parspack user.
     *
     * @return void
     */
    private function seedParspackUser(): void
    {
        $password = Str::random(8);
        UserFacade::removeUserByUsername('parspack');
        UserFacade::createUser('parspack', $password);
        echo ("New parspack user created with password: $password \n"); // This echo is just for testing purposes
    }

    private function seedDefaultProducts()
    {
        $products = ['A', 'B', 'C'];
        foreach ($products as $productName) {
            if (ProductFacade::findProductByName($productName))
                echo "Product $productName already exists \n";
            else {
                ProductFacade::createProduct($productName);
                echo "Product $productName created successfully \n";
            }
        }
    }
}
