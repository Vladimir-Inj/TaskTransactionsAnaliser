<?php
declare(strict_types = 1);

namespace Application\CurrencyRatesSource;

interface CurrencyRatesSourceInterface
{
    public function getRate(string $currency): float;
}