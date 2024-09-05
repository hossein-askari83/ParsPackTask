<?php

namespace App\Providers;

use App\Factories\Interfaces\UserFactoryInterface;
use App\Factories\UserFactory;
use App\Services\CommentService;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(Serializer::class, function (Application $app) {
            $classMetadataFactory =  $app->make(ClassMetadataFactory::class, ['loader' => new AttributeLoader()]);
            return new Serializer([
                $app->make(ObjectNormalizer::class, ['classMetadataFactory' => $classMetadataFactory]),
            ]);
        });

        $this->app->bind(UserFactoryInterface::class, UserFactory::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
