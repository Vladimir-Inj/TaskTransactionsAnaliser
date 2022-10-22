<?php
declare(strict_types = 1);

namespace Application\Models;

use Application\Exception\TransactionException;

class Transaction
{
    private string $bin;
    private float $amount;
    private string $currency;
    private float $amountEUR;
    private float $commissionAmount;

    public function __construct(string $bin, float $amount, string $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;

        if ($this->currency === 'EUR') {
            $this->amountEUR = $this->amount;
        }
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAmountEUR(): float
    {
        if (!isset($this->amountEUR)) {
            throw new TransactionException('Amount in EUR is not calculated at this moment');
        }

        return $this->amountEUR;
    }

    public function setAmountEUR(float $amount): void
    {
        $this->amountEUR = $amount;
    }

    public function getCommissionAmount(): float
    {
        if (!isset($this->commissionAmount)) {
            throw new TransactionException('Commission amount is not calculated at this moment');
        }

        return $this->commissionAmount;
    }

    public function setCommissionAmount(float $amount): void
    {
        $this->commissionAmount = $amount;
    }

    public static function createFromArray(array $data): self
    {
        if (empty($data['bin']) || empty($data['amount']) || empty($data['currency'])) {
            throw new TransactionException('Not enough data for creating transaction');
        }

        if (!is_numeric($data['amount'])) {
            throw new TransactionException("Value {$data['amount']} is unacceptable for amount field");
        }

        return new self($data['bin'], floatval($data['amount']), $data['currency']);
    }
}