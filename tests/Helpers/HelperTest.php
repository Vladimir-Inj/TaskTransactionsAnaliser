<?php

use Application\Helpers\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function IsEUDataProvider(): array
    {
        return [
            ['AA', false],
            ['US', false],
            ['CZ', true],
            ['ES', true],
            ['GR', true],
            ['RO', true],
        ];
    }

    /**
     * @dataProvider IsEUDataProvider
     * @covers Helper::isEU
     */
    public function testIsEU($country, $result): void
    {
        $this->assertEquals($result, Helper::isEU($country));
    }


    public function CeilToCentsDataProvider(): array
    {
        return [
            [10.33548, 10.34],
            [1.98953, 1.99],
            [0, 0],
            [99, 99],
            [-89462, -89462],
            [-9.595, -9.59],
        ];
    }

    /**
     * @dataProvider CeilToCentsDataProvider
     * @covers Helper::ceilToCents
     */
    public function testCeilToCents(float $number, float $result): void
    {
        $this->assertEquals($result, Helper::ceilToCents($number));
    }
}