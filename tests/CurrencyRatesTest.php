<?php

use PHPUnit\Framework\TestCase;
use App\CurrencyRates;

class CurrencyRatesTest extends TestCase
{
    private $currencyRates;

    protected function setUp() : void
    {
        $this->currencyRates = currencyRates::getInstance();
    }

    protected function tearDown() : void
    {
        $this->currencyRates->unsetInstance();
        $this->currencyRates = null;
    }

    /**
     * @covers \App\CurrencyRates
     */
    public function testGetInstance()
    {
        $this->assertInstanceOf(CurrencyRates::class, $this->currencyRates);
    }

    public function GetRateDataProvider() : array
    {
        return [
            ['EUR'],
            ['UAH'],
            ['USD'],
        ];
    }

    /**
     * @dataProvider GetRateDataProvider
     * @covers \App\CurrencyRates
     */
    public function testGetRateSuccess($currency)
    {
        $result = $this->currencyRates->getRate($currency);
        $this->assertIsNumeric($result);
    }

    /**
     * @covers \App\CurrencyRates
     */
    public function testGetRateFail()
    {
        $this->expectException(\Exception::class);
        $this->currencyRates->getRate('AAA');
    }
}