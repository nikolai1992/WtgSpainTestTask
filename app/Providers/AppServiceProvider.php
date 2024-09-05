<?php

namespace App\Providers;

use App\Services\BaseRepository;
use App\Services\BaseRepositoryInterface;
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
        //
        $this->bindRepositories();
    }

    private function bindRepositories(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
    }
}
