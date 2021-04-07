<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Asset\Repositories\AssetRepository;
use Modules\Asset\Repositories\ContactInterface;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
            $this->app->bind(ContactInterface::class,AssetRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
