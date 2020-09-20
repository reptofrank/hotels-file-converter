<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\FileConverter;
use Symfony\Component\HttpFoundation\File\File;

class InputFileTest extends TestCase
{
    
    public function testFileReadWithJSON()
    {
        $filePath = __DIR__ . '/../data/test_hotels.json';
        $file = new File($filePath);
        $data = FileConverter::read($file);
        $this->assertIsArray($data);
        $this->assertCount(13, $data);
    }

    public function testFileReadWithXML()
    {
        $filePath = __DIR__ . '/../data/test_hotels.xml';
        $file = new File($filePath);
        $data = FileConverter::read($file);
        $this->assertIsArray($data);
        $this->assertCount(15, $data);
    }

    public function testFileReadWithUnsupportedFormat()
    {
        $this->expectException(\Exception::class);
        $filePath = __DIR__ . '/../data/test_hotels.yaml';
        $file = new File($filePath);
        $data = FileConverter::read($file);
    }

    public function testASCIIOnlyString()
    {
        $hotelName = 'The Gibson';
        $response = FileConverter::isAscii($hotelName);
        $this->assertTrue($response);
    }

    public function testNonASCIIString()
    {
        $hotelName = 'The GibsonÝ';
        $response = FileConverter::isAscii($hotelName);
        $this->assertFalse($response);
    }

    public function testNegativeRating()
    {
        $stars = -3;
        $response = FileConverter::checkRating($stars);
        $this->assertFalse($response);
    }
}
