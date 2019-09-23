<?php

namespace Tintnaingwin\KuuPyaung\Exceptions;

use Exception;

class InvalidConvertJob extends Exception
{
    public static function noFilesToBeConvert()
    {
        return new static('There are no files to be backed up.');
    }
}
