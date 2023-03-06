<?php

namespace Tintnaingwin\KuuPyaung;

use Illuminate\Support\ServiceProvider;
use Tintnaingwin\KuuPyaung\Console\ConvertCommand;
use Tintnaingwin\KuuPyaung\Helpers\CommandOutput;

class KuuPyaungServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/kuu-pyaung.php' => config_path('kuu-pyaung.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/kuu-pyaung.php', 'kuu-pyaung');

        $this->commands(ConvertCommand::class);

        $this->app->singleton(CommandOutput::class);
    }
}
