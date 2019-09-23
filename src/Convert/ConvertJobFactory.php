<?php

namespace Tintnaingwin\KuuPyaung\Convert;

use Illuminate\Console\Command;

class ConvertJobFactory
{
    /**
     * @param \Illuminate\Console\Command $command
     *
     * @return \Tintnaingwin\KuuPyaung\Convert\ConvertJob
     */
    public static function create(Command $command)
    {
        return (new ConvertJob())->setCommand($command)->setIncludeFiles(config('kuu-pyaung.include_files'));
    }

}
