<?php

namespace Tintnaingwin\Kuu\Tests\Commands;

use Tintnaingwin\KuuPyaung\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class ConvertCommandTest extends TestCase
{
    /** @test */
    public function it_will_fail_when_try_to_convert_only_the_files_and_only_the_db()
    {
        $resultCode = Artisan::call('kuupyaung:run', [
            '--only-files' => true,
            '--only-database' => true
        ]);

        $this->assertEquals(1, $resultCode);

        $this->seeInConsoleOutput('Cannot use `only-database` and `only-files` together.');
    }

    /** @test */
    public function it_will_success()
    {
        Artisan::call('kuupyaung:run');

        $this->seeInConsoleOutput('Convert completed!');
    }
}
