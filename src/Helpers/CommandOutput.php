<?php

namespace Tintnaingwin\KuuPyaung\Helpers;

use Illuminate\Console\Command;

class CommandOutput
{
    /**
     * The console command instance.
     *
     * @var \Illuminate\Console\Command
     */
    protected $command;

    public function bind(Command $command): void
    {
        $this->command = $command;
    }

    public function __call($name, $arguments)
    {
        $command = $this->command ?: new NullCommand();

        return call_user_func_array([$command, $name], $arguments);
    }
}
