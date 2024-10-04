<?php namespace LaraJS\I18n;

use Illuminate\Support\ServiceProvider;
use LaraJS\I18n\Commands\GenerateInclude;

class GeneratorProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([GenerateInclude::class]);
        }

        $this->publishes([
            __DIR__ . '/../config/i18n.php' => config_path('i18n.php'),
        ]);

         $this->mergeConfigFrom(
             __DIR__ . '/../config/i18n.php',
            'i18n'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
