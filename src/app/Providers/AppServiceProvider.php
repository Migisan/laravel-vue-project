<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * 記事
         */
        $this->app->bind(
            \App\Repositories\ArticleRepositoryInterface::class,
            \App\Repositories\ArticleRepository::class,
        );
        $this->app->bind(
            \App\Services\ArticleServiceInterface::class,
            function ($app) {
                return new \App\Services\ArticleService(
                    $app->make(\App\Repositories\ArticleRepositoryInterface::class)
                );
            },
        );
        
        /**
         * ユーザー
         */
        $this->app->bind(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class,
        );
        $this->app->bind(
            \App\Services\UserServiceInterface::class,
            function ($app) {
                return new \App\Services\UserService(
                    $app->make(\App\Repositories\UserRepositoryInterface::class)
                );
            },
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
