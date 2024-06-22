<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use App\Models\BlogPost;
use App\Observers\BlogPostObserver;
use App\Services\Counter;
use Illuminate\Support\Facades\Event;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Blade::componentNamespace('components.badge','badge');

        BlogPost::observe(BlogPostObserver::class);
        // $this->app->bind(Counter::class, function($app){
        //      return new Counter(5);
        // });

        $this->app->singleton(Counter::class, function($app){
             return new Counter(
                $app->make('Illuminate\Contracts\Cache\Factory'),
                $app->make('Illuminate\Contracts\Session\Session'),
                env('COUNTER_TIMEOUT'));
        });

        $this->app->bind(

            'App\Contracts\CounterContract',
            Counter::class
        );

        // for single resources
        //CommentResource::withoutWrapping();
        JsonResource::withoutWrapping();
    }
}
