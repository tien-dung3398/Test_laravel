<?php

namespace Modules\Asset\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Asset\Repositories\AssetRepository;
use Modules\Asset\Repositories\ContactInterface;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContactInterface::class,AssetRepository::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
