<?php
declare(strict_types = 1);

namespace Application\CardsDetailsSource;

use Application\Exception\CardsDetailsSourceException;

class CardsDetailsSource
{
    private string $url;

    public function __construct($url)
    {
        $this->url = rtrim($url, '/') . '/';
    }

    public function get(string $bin): array
    {
        $binResults = @file_get_contents($this->url . $bin);
        if (empty($binResults)) {
            throw new CardsDetailsSourceException("Card {$bin} is not found on binlist. URL: {$this->url}{$bin}");
        }

        return json_decode($binResults, true);
    }
}