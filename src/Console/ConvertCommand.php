<?php

namespace Tintnaingwin\KuuPyaung\Console;

use Exception;
use Illuminate\Console\Command;
use Tintnaingwin\KuuPyaung\Convert\ConvertJobFactory;
use Tintnaingwin\KuuPyaung\Exceptions\InvalidCommand;
use Tintnaingwin\KuuPyaung\Helpers\CommandOutput;

class ConvertCommand extends Command
{
    protected $signature = 'kuupyaung:run {--only-database} {--only-files}';

    protected $description = 'Run the convert from zawgyi to unicode.';

    public function handle(): int
    {
        app(CommandOutput::class)->bind($this);

        try {
            $this->guardAgainstInvalidOptions();

            $convertJob = ConvertJobFactory::create();

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

            return self::SUCCESS;
        }

        return self::SUCCESS;
    }

    /**
     * Check the against invalid options.
     *
     * @throws InvalidCommand
     */
    protected function guardAgainstInvalidOptions(): void
    {
        if ($this->option('only-database') && $this->option('only-files')) {
            throw InvalidCommand::create('Cannot use `only-database` and `only-files` together');
        }
    }
}
