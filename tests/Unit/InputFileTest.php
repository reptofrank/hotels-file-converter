<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\FileConverter;
use Symfony\Component\HttpFoundation\File\File;

class InputFileTest extends TestCase
{
    
    public function testFileReadWithJSON()
    {
        $filePath = __DIR__ . '/hotels.json';
        $file = new File($filePath);
        $data = FileConverter::read($file);
        $this->assertIsArray($data);
        $this->assertCount(13, $data);
    }

    public function testFileReadWithXML()
    {
        $filePath = __DIR__ . '/hotels.xml';
        $file = new File($filePath);
        $data = FileConverter::read($file);
        $this->assertIsArray($data);
        $this->assertCount(15, $data);
    }
}
