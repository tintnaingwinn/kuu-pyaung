<?php

namespace Tintnaingwin\KuuPyaung\Tests;

use Tintnaingwin\KuuPyaung\KuuPyaungServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

abstract class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            KuuPyaungServiceProvider::class,
        ];
    }

    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Tintnaingwin\\KuuPyaung\\Tests\\Database\\Factories\\UserFactory'
        );
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function getEnvironmentSetUp($app)
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

    protected function seeInConsoleOutput($expectedText)
    {
        $consoleOutput = $this->app[Kernel::class]->output();

        $this->assertStringContainsString(
            $expectedText,
            $consoleOutput,
            "Did not see `{$expectedText}` in console output: `{$consoleOutput}`"
        );
    }

    protected function doNotSeeInConsoleOutput($unExpectedText)
    {
        $consoleOutput = $this->app[Kernel::class]->output();

        $this->assertStringNotContainsString(
            $unExpectedText,
            $consoleOutput,
            "Did not expect to see `{$unExpectedText}` in console output: `$consoleOutput`"
        );
    }
}
