<?php
declare(strict_types = 1);

namespace Application\Helpers;

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

    /**
     * Task says that commission must be not rounded, but ceiled to cents
     */
    public static function ceilToCents($price)
    {
        return ceil($price * 100) / 100;
    }
}