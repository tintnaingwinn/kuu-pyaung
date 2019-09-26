<?php

namespace Tintnaingwin\KuuPyaung\Helpers;

class NullCommand
{
    public function __call($method, $args)
    {
        return $this;
    }
}
