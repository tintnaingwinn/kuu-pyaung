<?php

namespace Tintnaingwin\KuuPyaung\Convert;

use Exception;
use Tintnaingwin\KuuPyaung\Exceptions\InvalidConvertJob;
use Tintnaingwin\MyanFont\Facades\MyanFont;
use Illuminate\Support\Facades\File;

class FileJob
{
    /*
     * These directories only will be convert.
     */
    protected $includeFolder;

    /**
     * FileJob constructor.
     */
    public function __construct()
    {
        $this->setIncludeFiles(config('kuu-pyaung.include_files'));
    }

    /**
     * The list of directories and files that will be included in the convert.
     * Convert the $includeFolder.
     *
     * @return void
     */
    public function convert()
    {
        try {
            if (!count($this->includeFolder)) {
                throw InvalidConvertJob::noFilesToBeConvert();
            }

            commandText()->info('Starting convert files from zawgyi to unicode...');
            commandText()->getOutput()->newLine();

            foreach ($this->includeFolder as $value) {

                commandText()->info("Converting $value files...");

                if ($this->isNotExistResourceFolder($value)) {
                    commandText()->error(resource_path($value) . " directory does not exist in resource folder.");
                    commandText()->getOutput()->newLine();
                    continue;
                }

                $files = File::allFiles(resource_path($value));

                if (!count($files)) {
                    commandText()->warn("There are no $value files to be converted.");
                    commandText()->getOutput()->newLine();
                    continue;
                }

                $this->convertFolder($value, $files);

            }

        } catch (Exception $exception) {
            commandText()->error("Convert failed because {$exception->getMessage()}");
            commandText()->getOutput()->newLine();
        }
    }

    /**
     * Convert the file contexts from zawgyi to unicode.
     *
     * @param string $name
     * @param \Symfony\Component\Finder\SplFileInfo[] $files
     *
     * @return void
     */
    public function convertFolder($name, $files)
    {
        commandText()->getOutput()->progressStart(count($files));

        foreach ($files as $path => $value) {

            $content = $value->getContents();

            $data = MyanFont::zg2uni($content);

            File::put(resource_path($name . '/' . $value->getRelativePathname()), $data);

            commandText()->getOutput()->progressAdvance();
        }

        commandText()->getOutput()->progressFinish();
    }

    /**
     * Determine if the resource folder is not empty.
     *
     * @param string $name
     * @return bool
     */
    protected function isNotExistResourceFolder($name)
    {
        return !File::exists(resource_path($name));
    }

    /**
     * @param array $includeFolder
     *
     * @return self
     */
    public function setIncludeFiles($includeFolder)
    {
        $this->includeFolder = $includeFolder;

        return $this;
    }
}
