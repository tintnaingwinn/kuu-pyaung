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
}
