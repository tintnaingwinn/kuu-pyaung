<?php

namespace Tintnaingwin\KuuPyaung\Console;

use Exception;
use Illuminate\Console\Command;
use Tintnaingwin\KuuPyaung\Convert\ConvertJobFactory;
use Tintnaingwin\KuuPyaung\Exceptions\InvalidCommand;

class ConvertCommand extends Command
{
    protected $signature = 'kuupyaung:run {--only-database} {--only-files}';

    protected $description = 'Run the convert from zawgyi to unicode.';

    /**
     * @return int
     */
    public function handle()
    {
        try {

            $this->guardAgainstInvalidOptions();

            $this->info('Starting convert from zawgyi to unicode...');
            $this->output->newLine();

            $convertJob = ConvertJobFactory::create($this);

            if ($this->option('only-database')) {
                $convertJob->dontConvertFiles();
            }

            if ($this->option('only-files')) {
                $convertJob->dontConvertDatabases();
            }

            $convertJob->run();

            $this->info('Convert completed!');

        } catch (Exception $exception) {

            $this->error("Convert failed because: {$exception->getMessage()}.");

            return 1;
        }
    }

    /**
     * Check the against invalid options.
     */
    protected function guardAgainstInvalidOptions()
    {
        if ($this->option('only-database') && $this->option('only-files')) {
            throw InvalidCommand::create('Cannot use only-database and only-files together');
        }
    }
}
