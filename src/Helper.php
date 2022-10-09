<?php

namespace App;

class Helper
{
    const EU_LIST = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public static function isEU($country)
    {
        return in_array($country, self::EU_LIST);
    }

    public static function ceilToCents($price)
    {
        return ceil($price * 100) / 100;
    }
}