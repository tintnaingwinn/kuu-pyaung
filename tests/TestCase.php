<?php

namespace Tintnaingwin\KuuPyaung\Tests;

use Tintnaingwin\KuuPyaung\KuuPyaungServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Contracts\Console\Kernel;

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

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {

    }

    protected function seeInConsoleOutput($expectedText)
    {
        $consoleOutput = $this->app[Kernel::class]->output();

        $this->assertStringContainsString(
            $expectedText,
            $consoleOutput,
            "Did not see `{$expectedText}` in console output: `$consoleOutput`"
        );
    }

}
