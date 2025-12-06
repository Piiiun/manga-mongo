<?php

namespace App\Providers;

use App\Models\Manga;
use App\Observers\MangaObserver;
use Illuminate\Support\ServiceProvider;

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
        Manga::observe(MangaObserver::class);
    }
}
