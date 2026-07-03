<?php

namespace App\Providers;

use App\Repositories\EloquentInfraestructuraRepository;
use App\Repositories\InfraestructuraRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(InfraestructuraRepositoryInterface::class, EloquentInfraestructuraRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
