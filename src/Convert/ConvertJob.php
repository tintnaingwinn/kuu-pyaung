<?php

namespace Tintnaingwin\KuuPyaung\Convert;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Tintnaingwin\MyanFont\Facades\MyanFont;

class ConvertJob implements ConvertJobInterface
{
    protected $includeFolder = ['views', 'lang'];

    protected $isConvertFiles = true;

    protected $isConvertDatabases = true;

    /**
     * The console command instance.
     *
     * @var \Illuminate\Console\Command
     */
    protected $command;

    /**
     * @throws \Exception
     */
    public function run()
    {
        if ($this->isConvertFiles) {
            $this->convertFolders();
        }

        if ($this->isConvertDatabases){
            $this->convertDatabase();
        }
    }

    /**
     * The list of directories and files that will be included in the convert.
     * Convert the $includeFolder
     *
     * @return void
     */
    public function convertFolders() {
        try {

            if (!count($this->includeFolder)) {
                $this->command->warn("There are no folder to be converted.");
            }

            foreach ($this->includeFolder as $value) {

                $this->command->info("Converting $value files...");

                if (!File::exists(resource_path($value))) {
                    $this->command->error(resource_path($value) . " directory does not exist");
                    $this->command->getOutput()->newLine();
                    continue;
                }

                $files = File::allFiles(resource_path($value));

                if (!count($files)) {
                    $this->command->warn("There are no $value files to be converted.");
                    continue;
                }

                $this->convertFolder($value, $files);

            }

        } catch (Exception $exception) {

            $this->command->error("Convert failed because {$exception->getMessage()}.".PHP_EOL.$exception->getTraceAsString());

        }
    }

    /**
     * @param string $name
     * @param \Symfony\Component\Finder\SplFileInfo[] $files
     *
     * @return void
     */
    public function convertFolder($name, $files)
    {
        $this->command->getOutput()->progressStart(count($files));

        foreach ($files as $path => $value) {

            $content = $value->getContents();

            $data = MyanFont::zg2uni($content);

            File::put(resource_path($name . '/' . $value->getRelativePathname()), $data);

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }

    public function convertDatabase()
    {
        // TODO: Implement convertDatabase() method.
    }

    /**
     * Set the console command instance.
     *
     * @param  \Illuminate\Console\Command  $command
     * @return $this
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * App will not convert files.
     *
     * @return self
     */
    public function dontConvertFiles()
    {
        $this->isConvertFiles = false;

        return $this;
    }

    /**
     * App will not convert database.
     *
     * @return self
     */
    public function dontConvertDatabases()
    {
        $this->isConvertDatabases = false;

        return $this;
    }


    /**
     * @param array $includeFolder
     *
     * @return ConvertJob
     */
    public function setIncludeFiles($includeFolder)
    {
        $this->includeFolder = $includeFolder;

        return $this;
    }
}
