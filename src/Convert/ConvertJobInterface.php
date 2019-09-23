<?php

namespace Tintnaingwin\KuuPyaung\Convert;

use Illuminate\Console\Command;

interface ConvertJobInterface
{
    public function run();

    public function convertFolder($name, $files);

    public function convertDatabase();

    public function dontConvertFiles();

    public function dontConvertDatabases();

    public function setCommand(Command $command);
}
