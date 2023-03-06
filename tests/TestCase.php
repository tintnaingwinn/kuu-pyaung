<?php

namespace Tintnaingwin\KuuPyaung\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Tintnaingwin\KuuPyaung\KuuPyaungServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders(Application $app): array
    {
        return [
            KuuPyaungServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Tintnaingwin\\KuuPyaung\\Tests\\Database\\Factories\\UserFactory'
        );
    }

    public function getEnvironmentSetUp(Application $app): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('desc');
            $table->text('location');
            $table->text('weather');
            $table->timestamps();
        });
    }

    protected function seeInConsoleOutput($expectedText): void
    {
        $consoleOutput = $this->app[Kernel::class]->output();

        $this->assertStringContainsString(
            $expectedText,
            $consoleOutput,
            "Did not see `{$expectedText}` in console output: `{$consoleOutput}`"
        );
    }

    protected function doNotSeeInConsoleOutput($unExpectedText): void
    {
        $consoleOutput = $this->app[Kernel::class]->output();

        $this->assertStringNotContainsString(
            $unExpectedText,
            $consoleOutput,
            "Did not expect to see `{$unExpectedText}` in console output: `$consoleOutput`"
        );
    }
}
