<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\AdminRepository::class, \App\Repositories\Eloquent\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShopRepository::class, \App\Repositories\Eloquent\ShopRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderRepository::class, \App\Repositories\Eloquent\OrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderProductRepository::class, \App\Repositories\Eloquent\OrderProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\Eloquent\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BankRepository::class, \App\Repositories\Eloquent\BankRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SettingRepository::class, \App\Repositories\Eloquent\SettingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShopUserRepository::class, \App\Repositories\Eloquent\ShopUserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BillRepository::class, \App\Repositories\Eloquent\BillRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\Eloquent\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CommentRepository::class, \App\Repositories\Eloquent\CommentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GalleryRepository::class, \App\Repositories\Eloquent\GalleryRepositoryEloquent::class);
        //:end-bindings:
    }
}
