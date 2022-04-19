<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Http\Resources\Json\JsonResource;

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
         * 認証
         */
        $this->app->bind(
            \App\Services\AuthServiceInterface::class,
            function ($app) {
                return new \App\Services\AuthService(
                    $app->make(\App\Repositories\UserRepositoryInterface::class)
                );
            },
        );

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
                    $app->make(\App\Repositories\UserRepositoryInterface::class),
                    $app->make(\App\Repositories\ArticleRepositoryInterface::class),
                    $app->make(\App\Repositories\LikeRepositoryInterface::class)
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

        /**
         * いいね
         */
        $this->app->bind(
            \App\Repositories\LikeRepositoryInterface::class,
            \App\Repositories\LikeRepository::class,
        );
        $this->app->bind(
            \App\Services\LikeServiceInterface::class,
            function ($app) {
                return new \App\Services\LikeService(
                    $app->make(\App\Repositories\LikeRepositoryInterface::class)
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
        // dataキーラッピングの無効化
        JsonResource::withoutWrapping();
    }
}
