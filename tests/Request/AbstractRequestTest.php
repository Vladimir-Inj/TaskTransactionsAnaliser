<?php

use Application\Request\AbstractRequest;
use PHPUnit\Framework\TestCase;

class AbstractRequestTest extends TestCase
{
    private ?AbstractRequest $abstractRequest;

    protected function setUp(): void
    {
        $this->abstractRequest = $this->getMockForAbstractClass(AbstractRequest::class);
    }

    protected function tearDown(): void
    {
        $this->abstractRequest = null;
    }

    public function SetPropertyDataProvider(): array
    {
        return [
            ['val1', 111111],
            ['val2', ['333333', -35, 'EUR', -345, 4]],
            ['val3', null],
        ];
    }

    /**
     * @dataProvider SetPropertyDataProvider
     * @covers AbstractRequest::getProperty
     * @covers AbstractRequest::setProperty
     */
    public function testSetProperty(string $property, $value): void
    {
        $this->abstractRequest->setProperty($property, $value);
        $this->assertEquals($value, $this->abstractRequest->getProperty($property));
    }
}