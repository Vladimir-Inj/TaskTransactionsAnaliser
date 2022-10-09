<?php

namespace App;

class CardsDB
{
    const URL = 'https://lookup.binlist.net/';

    public function getCardDetails(string $bin) : object
    {
        $binResults = @file_get_contents(self::URL . $bin);
        if (empty($binResults)) {
            throw new \Exception("Card {$bin} is not found on binlist");
        }

        return json_decode($binResults);
    }
}