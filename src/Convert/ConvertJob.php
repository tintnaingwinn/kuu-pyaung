<?php

namespace Tintnaingwin\KuuPyaung\Convert;

class ConvertJob implements ConvertJobInterface
{
    protected bool $isConvertFiles = true;

    protected bool $isConvertDatabases = true;

    /**
     * The FileJob implementation.
     */
    protected FileJob $fileJob;

    /**
     * The DatabaseJob implementation.
     */
    protected DatabaseJob $dbJob;

    public function run()
    {
        if ($this->isConvertFiles) {
            $this->convertFolders();
        }

        if ($this->isConvertDatabases) {
            $this->convertDatabase();
        }
    }

    /**
     * Convert the resource files from zawgyi to unicode.
     */
    public function convertFolders(): void
    {
        $this->fileJob->convert();
    }

    /**
     * Convert the database from zawgyi to unicode.
     */
    public function convertDatabase(): void
    {
        $this->dbJob->convert();
    }

    /**
     * Set the DatabaseJob Object.
     *
     * @return self
     */
    public function setDbJob(DatabaseJob $dbJob): static
    {
        $this->dbJob = $dbJob;

        return $this;
    }

    /**
     * Set the FileJob Object.
     *
     * @return self
     */
    public function setFileJob(FileJob $fileJob): static
    {
        $this->fileJob = $fileJob;

        return $this;
    }

    /**
     * App will not convert files.
     *
     * @return self
     */
    public function dontConvertFiles(): static
    {
        $this->isConvertFiles = false;

        return $this;
    }

    /**
     * App will not convert database.
     *
     * @return self
     */
    public function dontConvertDatabases(): static
    {
        $this->isConvertDatabases = false;

        return $this;
    }
}
