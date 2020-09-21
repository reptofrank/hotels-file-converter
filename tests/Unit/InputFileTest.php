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

    public function testFileReadWithUnsupportedFormat()
    {
        $filePath = __DIR__ . '/hotels.xml';
        $file = new File($filePath);
        $data = FileConverter::read($file);
        $this->assertIsArray($data);
        $this->assertCount(15, $data);
    }

    public function testHotelValidationWithValidInformation()
    {
        $hotel = [
            "name" => "The Gibson",
            "address" => "63847 Lowe Knoll, East Maxine, WA 97030-4876",
            "stars" => "5",
            "contact" => "Dr. Sinda Wyman",
            "phone" => "1-270-665-9933x1626",
            "uri" => "http://www.paucek.com/search.htm"
        ];

        $response = FileConverter::validateHotelData($hotel);
        $this->assertEquals(true, $response);
    }

    public function testHotelValidationWithInvalidName()
    {
        $hotel = [
            "name" => "The GibsonÝ",
            "address" => "63847 Lowe Knoll, East Maxine, WA 97030-4876",
            "stars" => "5",
            "contact" => "Dr. Sinda Wyman",
            "phone" => "1-270-665-9933x1626",
            "uri" => "http://www.paucek.com/search.htm"
        ];

        $response = FileConverter::validateHotelData($hotel);
        $this->assertEquals(false, $response);
    }

    public function testHotelValidationWithInvalidRating()
    {
        $hotel = [
            "name" => "The Gibson",
            "address" => "63847 Lowe Knoll, East Maxine, WA 97030-4876",
            "stars" => "-2",
            "contact" => "Dr. Sinda Wyman",
            "phone" => "1-270-665-9933x1626",
            "uri" => "http://www.paucek.com/search.htm"
        ];

        $response = FileConverter::validateHotelData($hotel);
        $this->assertEquals(false, $response);
    }

    public function testHotelValidationWithInvalidUrl()
    {
        $hotel = [
            "name" => "The Gibson",
            "address" => "63847 Lowe Knoll, East Maxine, WA 97030-4876",
            "stars" => "5",
            "contact" => "Dr. Sinda Wyman",
            "phone" => "1-270-665-9933x1626",
            "uri" => "www.paucek.com/search.htm"
        ];

        $response = FileConverter::validateHotelData($hotel);
        $this->assertEquals(false, $response);
    }
    
}
