<?php
declare(strict_types = 1);

namespace Application\CurrencyRatesSource;

use Application\Config;
use Application\Exception\CurrencyRatesException;

class CurrencyRatesSourceFactory
{
    public static function getCurrencyRatesSource(Config $config): CurrencyRatesSourceInterface
    {
        switch ($config->get('currency_rates_source')) {
            case 'exchangerates':
                $settings = $config->get('exchangerates');
                return new ExchangeratesCurrencyRatesSource($settings['url'], $settings['api_key']);

            case null:
                throw new CurrencyRatesException('Setting "exchangerates" is missing in the configuration file');

            default:
                throw new CurrencyRatesException("{$config->get('currency_rates_source')} is unknown currency rates source");
        }
    }
}