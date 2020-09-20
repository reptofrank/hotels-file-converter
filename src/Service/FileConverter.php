<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\File;

class FileConverter
{
    private $rootPath;

    function __construct($rootPath) {
        $this->rootPath = $rootPath;
    }

    /**
     * Convert 
     */
    public function convert(string $filename)
    {
        $inputFile = new File($filename);
        $data = self::read($inputFile);

        foreach ($data as $index => $hotel) {
            
        }

        return $data;
    }

    /**
     * Decode file contents and return as array
     * @param File $file 
     * @return array
     * @throws Exception if file format not supported
     */
    public static function read($file)
    {
        $fh = $file->openFile('r');
        $content = $fh->fread($fh->getSize());
        
        switch ($file->getExtension()) {
            case 'json':
                $data = json_decode($content, true);
                break;
            case 'xml':
                $xml = simplexml_load_string($content);
                $json = json_encode($xml);
                $data = json_decode($json,TRUE)['hotel'];
                break;
            // Add more file types
            default:
                throw new \Exception("File format not supported");
                break;
        }

        return $data;
    }

    /**
     * Check if string contains only ASCII characters
     * @param string $str
     * @return bool
     */
    public static function isAscii(string $str)
    {
        return mb_check_encoding($str, 'ASCII');
    }

    /**
     * Check to rating is between 0 and 5
     * @param int $stars rating
     * @return bool
     */
    public static function checkRating(int $stars)
    {
        return $stars >= 0 && $stars <= 5;
    }

    /**
     * Validate URL 
     * A valid URL must the following in order: 
     * 1: a protocol (http:// or https://)
     * 2: a hostname (optional)
     * 3: a domain name which can contain alphanumeric characters and/or a hyphen only
     * 4: tld
     * 
     * @param string $url
     * @return bool
     */
    public static function isUrlValid(string $url)
    {
        $urlRegex = '/^(http(s?)):\/\/([a-zA-Z0-9]+\.)?[a-zA-Z0-9-]+\.[a-z]{2,6}\//';
        return preg_match($urlRegex, $url);
    }
}
