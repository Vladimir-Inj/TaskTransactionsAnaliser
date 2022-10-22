<?php
declare(strict_types = 1);

namespace Application\Reader;

use Application\Exception\ReaderException;

class ReaderFactory
{
    public static function getReader(string $filename): ReaderInterface
    {
        if (! is_file($filename)) {
            throw new ReaderException("File {$filename} is not exists");
        }

        $mimeType = mime_content_type($filename);
        if ($mimeType === 'application/json') {
            return new JsonTextReader($filename);
        } else {
            throw new ReaderException("Can't work with {$mimeType} file");
        }
    }
}