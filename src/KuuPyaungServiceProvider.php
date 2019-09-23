<?php
namespace Tintnaingwin\KuuPyaung;

use Illuminate\Support\ServiceProvider;
use Tintnaingwin\KuuPyaung\Console\ConvertCommand;

class KuuPyaungServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/kuu-pyaung.php' => config_path('kuu-pyaung.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/kuu-pyaung.php', 'kuu-pyaung');

        $this->commands(ConvertCommand::class);
    }
}
