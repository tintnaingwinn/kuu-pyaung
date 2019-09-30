<?php

namespace Tintnaingwin\KuuPyaung\Exceptions;

use Exception;

class InvalidConvertJob extends Exception
{
    public static function noFilesToBeConvert()
    {
        return new static('there are no files to be converted.');
    }

    public static function noTableToBeConvert()
    {
        return new static('there are no table to be converted.');
    }

    public static function noPrimaryKey($table)
    {
        return new static("there are no primary key at the {$table} table");
    }
}
