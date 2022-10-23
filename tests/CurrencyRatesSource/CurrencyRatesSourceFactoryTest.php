<?php

use Application\Config;
use Application\CurrencyRatesSource\CurrencyRatesSourceFactory;
use Application\CurrencyRatesSource\ExchangeratesCurrencyRatesSource;
use Application\Exception\CurrencyRatesException;
use PHPUnit\Framework\TestCase;

class CurrencyRatesSourceFactoryTest extends TestCase
{
    private ?Config $config;

    protected function setUp(): void
    {
        $this->config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get'])
            ->getMock();
    }

    protected function tearDown(): void
    {
        $this->config = null;
    }

    /**
     * @covers CurrencyRatesSourceFactory::getCurrencyRatesSource
     */
    public function testGetCurrencyRatesSourceExchagerates(): void
    {
        $this->config->expects($this->exactly(2))
            ->method('get')
            ->withConsecutive(
                ['currency_rates_source'],
                ['exchangerates']
            )
            ->willReturnOnConsecutiveCalls(
                'exchangerates',
                [
                    'url' => 'https://api.apilayer.com/exchangerates_data/latest?base=EUR',
                    'api_key' => 'zf0Igsi3tR9qSK65MaxfzuZjEiprnO82',
                ]
            );

        $this->assertInstanceOf(ExchangeratesCurrencyRatesSource::class, CurrencyRatesSourceFactory::getCurrencyRatesSource($this->config));
    }

    /**
     * @covers CurrencyRatesSourceFactory::getCurrencyRatesSource
     */
    public function testGetCurrencyRatesSourceNull(): void
    {
        $this->config->expects($this->once())
            ->method('get')
            ->with('currency_rates_source')
            ->willReturn(null);

        $this->expectException(CurrencyRatesException::class);
        CurrencyRatesSourceFactory::getCurrencyRatesSource($this->config);
    }

    /**
     * @covers CurrencyRatesSourceFactory::getCurrencyRatesSource
     */
    public function testGetCurrencyRatesSourceNonExists(): void
    {
        $this->config->expects($this->exactly(2))
            ->method('get')
            ->with('currency_rates_source')
            ->willReturn('non_exists');

        $this->expectException(CurrencyRatesException::class);
        CurrencyRatesSourceFactory::getCurrencyRatesSource($this->config);
    }
}