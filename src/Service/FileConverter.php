<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\File;

class FileConverter
{
    private $file;

    function __construct($filename) {
        $this->file = new File($filename, false);
    }
}
