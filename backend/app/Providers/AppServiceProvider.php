<?php

namespace App\Providers;

use App\Services\Post\PostService;
use App\Services\Post\PostServiceConstruct;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        //Service
        PostServiceConstruct::class => PostService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
