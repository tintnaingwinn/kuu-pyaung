<?php

namespace Tintnaingwin\KuuPyaung\Exceptions;

use Exception;

class InvalidCommand extends Exception
{
    public static function create($reason)
    {
        return new static($reason);
    }
}
