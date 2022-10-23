<?php

use Application\CardsDetailsSource\CardsDetailsSource;
use Application\Config;
use Application\CurrencyRatesSource\ExchangeratesCurrencyRatesSource;
use Application\Models\Transaction;
use Application\Reader\JsonTextReader;
use Application\TransactionsAnalyser;
use PHPUnit\Framework\TestCase;

class TransactionsAnalyserTest extends TestCase
{
    private ?JsonTextReader $reader;
    private ?CardsDetailsSource $cardsDetailsSource;
    private ?ExchangeratesCurrencyRatesSource $currencyRatesSource;
    private ?TransactionsAnalyser $transactionsAnalyser;

    private const RATES = ['eu' => 0.01, 'not_eu' => 0.02];
    private const CARD_DETAILS = ['country' => ['alpha2' => 'UA']];
    private const TRANSACTIONS = [
        ['bin' => '45717360', 'amount' => 100.00, 'currency' => 'EUR'],
        ['bin' => '516793', 'amount' => 50.00, 'currency' => 'USD'],
        ['bin' => '45417360', 'amount' => 10000.00, 'currency' => 'JPY'],
    ];

    protected function setUp(): void
    {
        $config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get'])
            ->getMock();
        $config->expects($this->once())
            ->method('get')
            ->with('commission_rates')
            ->willReturn(self::RATES);

        $this->reader = $this->getMockBuilder(JsonTextReader::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['read', '__destruct'])
            ->getMock();

        $this->cardsDetailsSource = $this->getMockBuilder(CardsDetailsSource::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get'])
            ->getMock();

        $this->currencyRatesSource = $this->getMockBuilder(ExchangeratesCurrencyRatesSource::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getRate'])
            ->getMock();

        $this->transactionsAnalyser = new TransactionsAnalyser($config, $this->reader, $this->cardsDetailsSource, $this->currencyRatesSource);
    }

    protected function tearDown(): void
    {
        $this->transactionsAnalyser = null;
        $this->reader = null;
        $this->cardsDetailsSource = null;
        $this->currencyRatesSource = null;
    }

    /**
     * @covers TransactionsAnalyser::loadTransactions
     * @covers TransactionsAnalyser::getCommissionRate
     * @covers TransactionsAnalyser::getTransactions
     * @covers TransactionsAnalyser::getCommissionRate
     */
    public function testLoadTransactions(): void
    {
        $this->reader->expects($this->once())
            ->method('read')
            ->willReturn(self::TRANSACTIONS);

        $this->cardsDetailsSource->expects($this->any())
            ->method('get')
            ->willReturn(self::CARD_DETAILS);

        $this->transactionsAnalyser->loadTransactions();

        $transactions = $this->transactionsAnalyser->getTransactions();
        foreach ($transactions as $key => $transaction) {
            $this->assertInstanceOf(Transaction::class, $transaction);
            $this->assertIsNumeric($transaction->getCommissionAmount());
            $this->assertEquals(self::TRANSACTIONS[$key]['bin'], $transaction->getBin());
            $this->assertEquals(self::TRANSACTIONS[$key]['amount'], $transaction->getAmount());
            $this->assertEquals(self::TRANSACTIONS[$key]['currency'], $transaction->getCurrency());
        }
    }
}