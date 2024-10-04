<?php namespace LaraJS\I18n;

use Illuminate\Support\ServiceProvider;
use LaraJS\I18n\Commands\GenerateInclude;

class LaraJSI18nProvider extends ServiceProvider
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
        $this->app->singleton('larajs.i18n', function () {
            return new Commands\GenerateInclude;
        });

        $this->commands('larajs.i18n');

        if ($this->app->runningInConsole()) {
            $this->commands([GenerateInclude::class]);
        }

        $this->publishes([
            __DIR__ . '/../config/i18n.php' => config_path('i18n.php'),
        ], 'larajs-i18n');

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
