<?php

namespace App\Console\Commands;

use App\Facades\ProductFacade;
use Illuminate\Console\Command;

class CreateNewProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create new product with given name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (ProductFacade::findProductByName($name))
            echo "Product $name already exists \n";
        else {
            ProductFacade::createProduct($name);
            echo "Product $name created successfully \n";
        }
    }
}
