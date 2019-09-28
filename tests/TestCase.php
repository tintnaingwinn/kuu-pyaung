<?php

namespace Tintnaingwin\KuuPyaung\Tests;

use Tintnaingwin\KuuPyaung\KuuPyaungServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
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

    public function setUp()
    {
        parent::setUp();
        $this->setUpDatabase();
        $this->app->make(EloquentFactory::class)->load(__DIR__.'/factories');
    }

    protected function setUpDatabase()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('desc');
            $table->text('location');
            $table->text('weather');
            $table->timestamps();
        });
        Schema::create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }

    protected function seeInConsoleOutput($expectedText)
    {
        $consoleOutput = $this->app[Kernel::class]->output();

        $this->assertContains(
            $expectedText,
            $consoleOutput,
            "Did not see `{$expectedText}` in console output: `{$consoleOutput}`"
        );
    }

    protected function doNotSeeInConsoleOutput($unExpectedText)
    {
        $consoleOutput = $this->app[Kernel::class]->output();
        $this->assertNotContains(
            $unExpectedText,
            $consoleOutput,
            "Did not expect to see `{$unExpectedText}` in console output: `$consoleOutput`"
        );
    }
}
