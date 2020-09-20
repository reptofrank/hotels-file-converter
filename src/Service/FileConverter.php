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
}
