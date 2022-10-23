<?php

use Application\CardsDetailsSource\CardsDetailsSource;
use Application\Exception\CardsDetailsSourceException;
use PHPUnit\Framework\TestCase;

class CardsDetailsSourceTest extends TestCase
{
    private ?CardsDetailsSource $cardsDetailsSource;

    protected function setUp(): void
    {
        $this->cardsDetailsSource = new CardsDetailsSource('https://lookup.binlist.net/');
    }

    protected function tearDown(): void
    {
        $this->cardsDetailsSource = null;
    }

    public function GetCardDetailsDataProvider(): array
    {
        return [
            ['516793', 'mastercard'],
            ['41417360', 'visa'],
            ['4745030', 'visa'],
        ];
    }

    /**
     * @dataProvider GetCardDetailsDataProvider
     * @covers CardsDetailsSource::get
     */
    public function testGetCardDetailsSuccess(string $bin, string $provider): void
    {
        $result = $this->cardsDetailsSource->get($bin);
        $this->assertIsArray($result);
        $this->assertEquals($provider, $result['scheme']);
    }

    /**
     * @covers CardsDetailsSource::get
     */
    public function testGetCardDetailsFail(): void
    {
        $this->expectException(CardsDetailsSourceException::class);
        $this->cardsDetailsSource->get('AAA');
    }
}