<?php

use PHPUnit\Framework\TestCase;
use App\CardsDB;

class CardsDBTest extends TestCase
{
    private $cardsDB;

    protected function setUp() : void
    {
        $this->cardsDB = new CardsDB();
    }

    protected function tearDown() : void
    {
        $this->cardsDB = null;
    }

    public function GetCardDetailsDataProvider() : array
    {
        return [
            ['516793', 'mastercard'],
            ['41417360', 'visa'],
            ['4745030', 'visa'],
        ];
    }

    /**
     * @dataProvider GetCardDetailsDataProvider
     * @covers \App\CardsDB
     */
    public function testGetCardDetailsSuccess($bin, $provider)
    {
        $result = $this->cardsDB->getCardDetails($bin);
        $this->assertIsObject($result);
        $this->assertEquals($provider, $result->scheme);
    }

    /**
     * @covers \App\CardsDB
     */
    public function testGetCardDetailsFail()
    {
        $this->expectException(\Exception::class);
        $this->cardsDB->getCardDetails('AAA');
    }
}