<?php

namespace Tintnaingwin\KuuPyaung\Convert;

class ConvertJob implements ConvertJobInterface
{
    protected $isConvertFiles = true;

    protected $isConvertDatabases = true;

    /**
     * The FileJob implementation.
     *
     * @var FileJob
     */
    protected $fileJob;

    /**
     * The DatabaseJob implementation.
     *
     * @var DatabaseJob
     */
    protected $dbJob;

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
     * Convert the resource files from zawgyi to unicode.
     *
     * @return void
     */
    public function convertFolders()
    {
        $this->fileJob->convert();
    }

    /**
     * Convert the database from zawgyi to unicode.
     *
     * @return void
     */
    public function convertDatabase()
    {
        $this->dbJob->convert();
    }

    /**
     * Set the DatabaseJob Object.
     *
     * @return self
     */
    public function setDbJob(DatabaseJob $dbJob)
    {
        $this->dbJob = $dbJob;

        return $this;
    }

    /**
     * Set the FileJob Object.
     * @return self
     */
    public function setFileJob(FileJob $fileJob)
    {
        $this->fileJob = $fileJob;

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
}
