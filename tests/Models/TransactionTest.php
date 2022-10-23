<?php

use Application\Exception\TransactionException;
use Application\Models\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function TransactionDataProvider(): array
    {
        return [
            ['111111', 10.0, 'EUR', 102.0, 1],
            ['222222', 15, 'EUR', 152, 0.5],
            ['333333', -35, 'EUR', -345, 4],
        ];
    }

    /**
     * @dataProvider TransactionDataProvider
     * @covers Transaction::getBin
     * @covers Transaction::getCurrency
     * @covers Transaction::getAmount
     * @covers Transaction::setAmountEUR
     * @covers Transaction::assertEquals
     * @covers Transaction::setCommissionAmount
     * @covers Transaction::getCommissionAmount
     */
    public function testGettersAndSetters(string $bin, float $amount, string $currency, float $amountEUR, float $commissionAmount): void
    {
        $transaction = new Transaction($bin, $amount, $currency);
        $this->assertInstanceOf(Transaction::class, $transaction);

        $this->assertEquals($bin, $transaction->getBin());
        $this->assertEquals($amount, $transaction->getAmount());
        $this->assertEquals($currency, $transaction->getCurrency());

        $transaction->setAmountEUR($amountEUR);
        $this->assertEquals($amountEUR, $transaction->getAmountEUR());

        $transaction->setCommissionAmount($commissionAmount);
        $this->assertEquals($commissionAmount, $transaction->getCommissionAmount());
    }


    /**
     * @dataProvider TransactionDataProvider
     * @covers Transaction::createFromArray
     */
    public function testCreateFromArraySuccess(string $bin, float $amount, string $currency): void
    {
        $transaction = Transaction::createFromArray([
            'bin' => $bin,
            'amount' => $amount,
            'currency' => $currency,
        ]);
        $this->assertInstanceOf(Transaction::class, $transaction);
    }

    /**
     * @covers Transaction::createFromArray
     */
    public function testCreateFromArrayFail(): void
    {
        $this->expectException(TransactionException::class);
        Transaction::createFromArray([]);
    }
}