<?php

use Illuminate\Support\Facades\Artisan;

it('will fail when try to convert only the files and only the db', function () {
    $resultCode = Artisan::call('kuupyaung:run --only-files --only-database');

    $this->assertEquals(0, $resultCode);

    $this->seeInConsoleOutput('Cannot use `only-database` and `only-files` together.');
});

it('will success', function () {
    Artisan::call('kuupyaung:run');

    $this->seeInConsoleOutput('Convert completed!');
});

it('will try to convert only the files', function () {
    Artisan::call('kuupyaung:run --only-files');

    $this->doNotSeeInConsoleOutput('Starting convert database from zawgyi to unicode');
});

it('will try to convert only the db', function () {
    Artisan::call('kuupyaung:run --only-database');

    $this->doNotSeeInConsoleOutput('Starting convert files from zawgyi to unicode');
});

it('will success when try to convert only the files', function () {
    Artisan::call('kuupyaung:run --only-files');

    $this->seeInConsoleOutput('Convert completed!');
});

it('will success when try to convert only the db', function () {
    Artisan::call('kuupyaung:run --only-database');

    $this->seeInConsoleOutput('Convert completed!');
});
