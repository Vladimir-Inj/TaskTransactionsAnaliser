<?php

namespace App;

class TransactionsAnaliser
{
    const EU_COMMISSION_RATE = 0.01;
    const NOT_EU_COMMISSION_RATE = 0.02;

    /* @var Transaction[] */
    private array $transactions = [];

    private CardsDB $cardsDB;

    public function __construct()
    {
        $this->cardsDB = new CardsDB();
    }

    public function loadTransactions($filename)
    {
        $reader = new TransactionsFileReader($filename);
        foreach ($reader->getData() as $transaction) {
            $cardDetails = $this->cardsDB->getCardDetails($transaction->bin);
            $commissionRate = Helper::isEU($cardDetails->country->alpha2) ? self::EU_COMMISSION_RATE : self::NOT_EU_COMMISSION_RATE;
            $transaction->commissionAmount = Helper::ceilToCents($transaction->getAmountEUR() * $commissionRate);

            $this->transactions[] = $transaction;
        }
    }

    public function printTransactions()
    {
        foreach ($this->transactions as $transaction) {
            echo $transaction->commissionAmount . PHP_EOL;
        }
    }
}