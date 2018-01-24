<?php

namespace BotMan\Drivers\Web\Providers;

use BotMan\Drivers\Web\SymfonyWebDriver;
use Illuminate\Support\ServiceProvider;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Studio\Providers\StudioServiceProvider;

class SymfonyWebServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->isRunningInBotManStudio()) {
            $this->loadDrivers();

            $this->publishes([
                __DIR__.'/../../stubs/symfony_web.php' => config_path('botman/symfony_web.php'),
            ]);

            $this->mergeConfigFrom(__DIR__.'/../../stubs/symfony_web.php', 'botman.symfony_web');
        }
    }

    /**
     * Load BotMan drivers.
     */
    protected function loadDrivers()
    {
        DriverManager::loadDriver(SymfonyWebDriver::class);
    }

    /**
     * @return bool
     */
    protected function isRunningInBotManStudio()
    {
        return class_exists(StudioServiceProvider::class);
    }
}
