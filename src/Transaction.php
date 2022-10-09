<?php

namespace App;

class Transaction
{
    public string $bin;
    public float $amount;
    public string $currency;

    private float $amountEUR;
    public float $commissionAmount;

    public function __construct($bin, $amount, $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmountEUR() : float
    {
        if (!isset($this->amountEUR)) {
            $currency_rate = CurrencyRates::getInstance()->getRate($this->currency);
            $this->amountEUR = $currency_rate > 0 ? $currency_rate * $this->amount : $this->amount;
        }

        return $this->amountEUR;
    }
}