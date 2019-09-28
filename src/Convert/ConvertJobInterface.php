<?php

namespace Tintnaingwin\KuuPyaung\Convert;

interface ConvertJobInterface
{
    public function run();

    public function convertFolders();

    public function convertDatabase();

    public function dontConvertFiles();

    public function dontConvertDatabases();
}
