<?php
declare(strict_types = 1);

namespace Application\Reader;

interface ReaderInterface
{
    public function read(): iterable;
}