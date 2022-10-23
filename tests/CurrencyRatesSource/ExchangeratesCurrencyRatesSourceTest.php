<?php

use Application\CurrencyRatesSource\ExchangeratesCurrencyRatesSource;
use Application\Exception\CurrencyRatesException;
use PHPUnit\Framework\TestCase;

class ExchangeratesCurrencyRatesSourceTest extends TestCase
{
    private ?ExchangeratesCurrencyRatesSource $exchangerates;

    protected function setUp(): void
    {
        $this->exchangerates = new ExchangeratesCurrencyRatesSource('https://api.apilayer.com/exchangerates_data/latest?base=EUR', 'zf0Igsi3tR9qSK65MaxfzuZjEiprnO82');
    }

    protected function tearDown(): void
    {
        $this->exchangerates = null;
    }

    /**
     * @covers ExchangeratesCurrencyRatesSource::init
     * @covers ExchangeratesCurrencyRatesSource::runApiRequest
     */
    public function testInit(): void
    {
        $this->assertInstanceOf(ExchangeratesCurrencyRatesSource::class, $this->exchangerates);
    }

    public function GetRateDataProvider(): array
    {
        return [
            ['EUR'],
            ['UAH'],
            ['USD'],
        ];
    }

    /**
     * @dataProvider GetRateDataProvider
     * @covers ExchangeratesCurrencyRatesSource::getRate
     */
    public function testGetRateSuccess(string $currency): void
    {
        $result = $this->exchangerates->getRate($currency);
        $this->assertIsNumeric($result);
    }

    /**
     * @covers ExchangeratesCurrencyRatesSource::getRate
     */
    public function testGetRateFail(): void
    {
        $this->expectException(CurrencyRatesException::class);
        $this->exchangerates->getRate('AAA');
    }
}