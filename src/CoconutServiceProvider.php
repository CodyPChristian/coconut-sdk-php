<?php namespace CodyPChristian\Coconut;

use Illuminate\Support\ServiceProvider;

class CoconutServiceProvider extends ServiceProvider
{
//
    //    /**
    //     * Indicates if loading of the provider is deferred.
    //     *
    //     * @var bool
    //     */
    //    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/coconut.php';
        $this->mergeConfigFrom($configPath, 'coconut');

        $this->app->singleton('coconut', function () {
            return new Coconut;
        });
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

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/coconut.php' => config_path('coconut.php'),
        ]);
    }

}
