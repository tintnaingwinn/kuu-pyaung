<?php

namespace Tintnaingwin\KuuPyaung\Tests\Commands;

use Tintnaingwin\KuuPyaung\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class ConvertCommandTest extends TestCase
{
    /** @test */
    public function it_will_fail_when_try_to_convert_only_the_files_and_only_the_db()
    {
        $resultCode = Artisan::call('kuupyaung:run --only-files --only-database');

        $this->assertEquals(1, $resultCode);

        $this->seeInConsoleOutput('Cannot use `only-database` and `only-files` together.');
    }

    /** @test */
    public function it_will_success()
    {
        Artisan::call('kuupyaung:run');

        $this->seeInConsoleOutput('Convert completed!');
    }

    /** @test */
    public function it_will_try_to_convert_only_the_files()
    {
        Artisan::call('kuupyaung:run --only-files');

        $this->doNotSeeInConsoleOutput('Starting convert database from zawgyi to unicode');
    }

    /** @test */
    public function it_will_try_to_convert_only_the_db()
    {
        Artisan::call('kuupyaung:run --only-database');

        $this->doNotSeeInConsoleOutput('Starting convert files from zawgyi to unicode');
    }

    /** @test */
    public function it_will_success_when_try_to_convert_only_the_files()
    {
        Artisan::call('kuupyaung:run --only-files');

        $this->seeInConsoleOutput('Convert completed!');
    }

    /** @test */
    public function it_will_success_when_try_to_convert_only_the_db()
    {
        Artisan::call('kuupyaung:run --only-database');

        $this->seeInConsoleOutput('Convert completed!');
    }
}
