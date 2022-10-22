<?php
declare(strict_types = 1);

namespace Application;

use Application\CardsDetailsSource\CardsDetailsSource;
use Application\CurrencyRatesSource\CurrencyRatesSourceInterface;
use Application\Exception\AppException;
use Application\Exception\TransactionException;
use Application\Helpers\Helper;
use Application\Models\Transaction;
use Application\Reader\ReaderInterface;

class TransactionsAnalyser
{
    private ReaderInterface $reader;
    private CardsDetailsSource $CardsDetailsSource;
    private CurrencyRatesSourceInterface $currencyRates;

    private float $eu_comission_rate;
    private float $not_eu_comission_rate;

    /* @var Transaction[] */
    private array $transactions = [];

    public function __construct(Config $config, ReaderInterface $reader, CardsDetailsSource $CardsDetailsSource, CurrencyRatesSourceInterface $currencyRates)
    {
        $this->config = $config;
        $this->reader = $reader;
        $this->CardsDetailsSource = $CardsDetailsSource;
        $this->currencyRates = $currencyRates;

        $comissionRates = $this->config->get('commission_rates');
        if (is_array($comissionRates) && is_numeric($comissionRates['eu']) && is_numeric($comissionRates['not_eu'])) {
            $this->eu_comission_rate = floatval($comissionRates['eu']);
            $this->not_eu_comission_rate = floatval($comissionRates['not_eu']);
        } else {
            throw new AppException('Section "commision_rates" in configuration file set not correctly');
        }
    }

    public function loadTransactions(): void
    {
        foreach ($this->reader->read() as $rawData) {
            $transaction = Transaction::createFromArray($rawData);

            $currency_rate = $this->currencyRates->getRate($transaction->getCurrency());
            $transaction->setAmountEUR($currency_rate > 0 ? $currency_rate * $transaction->getAmount() : $transaction->getAmount());

            $commissionAmount = Helper::ceilToCents($transaction->getAmountEUR() * $this->getCommissionRate($transaction->getBin()));
            $transaction->setCommissionAmount($commissionAmount);

            $this->transactions[] = $transaction;
        }
    }

    private function getCommissionRate(string $bin): float
    {
        $cardDetails = $this->CardsDetailsSource->get($bin);
        return Helper::isEU($cardDetails['country']['alpha2']) ? $this->eu_comission_rate : $this->not_eu_comission_rate;
    }

    public function printTransactions(): void
    {
        foreach ($this->transactions as $transaction) {
            echo $transaction->getCommissionAmount() . PHP_EOL;
        }
    }
}