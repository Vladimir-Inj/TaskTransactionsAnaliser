<?php
declare(strict_types = 1);

namespace Application\Reader;

/**
 * This class reads file where each line is json object
 */
class JsonTextReader implements ReaderInterface
{
    private $fileHandler;

    public function __construct(string $filename)
    {
        $this->fileHandler = fopen($filename, 'r');
    }

    public function read(): iterable
    {
        while(($line = fgets($this->fileHandler)) !== false) {
            yield json_decode($line, true);
        }

        return null;
    }

    public function __destruct()
    {
        fclose($this->fileHandler);
    }
}