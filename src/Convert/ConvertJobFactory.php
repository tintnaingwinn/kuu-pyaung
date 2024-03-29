<?php

namespace Tintnaingwin\KuuPyaung\Convert;

class ConvertJobFactory
{
    /**
     * @return \Tintnaingwin\KuuPyaung\Convert\ConvertJob
     */
    public static function create(): ConvertJob
    {
        return (new ConvertJob())
            ->setFileJob(static::createFileJob())
            ->setDbJob(static::createDbJob());
    }

    /**
     * @return \Tintnaingwin\KuuPyaung\Convert\DatabaseJob
     */
    protected static function createDbJob(): DatabaseJob
    {
        return new DatabaseJob();
    }

    /**
     * @return \Tintnaingwin\KuuPyaung\Convert\FileJob
     */
    protected static function createFileJob(): FileJob
    {
        return new FileJob();
    }
}
