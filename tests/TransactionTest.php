<?php

use PHPUnit\Framework\TestCase;
use App\Transaction;

/**
 * This is not a full test.
 * For correct testing need to decouple Transaction from CurrencyRates
 */
class TransactionTest extends TestCase
{
    public function TransactionDataProvider() : array
    {
        return [
            ['111111', 10.0, 'EUR'],
            ['222222', 15, 'EUR'],
            ['333333', -35, 'EUR'],
        ];
    }

    /**
     * @dataProvider TransactionDataProvider
     * @covers \App\Transaction
     */
    public function testTransaction($bin, $amount, $currency)
    {
        $transaction = new Transaction($bin, $amount, $currency);
        $this->assertInstanceOf(Transaction::class, $transaction);
    }
}