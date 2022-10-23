<?php

use Application\Reader\JsonTextReader;
use PHPUnit\Framework\TestCase;

class JsonTextReaderTest extends TestCase
{
    private ?JsonTextReader $reader;
    private CONST FILE_NAME = 'jsonText.txt';

    protected function setUp(): void
    {
        $content = implode(PHP_EOL, $this->ReadDataProvider()[0][0]);
        file_put_contents(self::FILE_NAME, $content);
        $this->reader = new JsonTextReader(self::FILE_NAME);
    }

    protected function tearDown(): void
    {
        $this->reader = null;
        unlink(self::FILE_NAME);
    }

    public function ReadDataProvider(): array
    {
        return [
            [[
            '{"bin":"45717360","amount":"100.00","currency":"EUR"}',
            '{"bin":"516793","amount":"50.00","currency":"USD"}',
            '{"bin":"45417360","amount":"10000.00","currency":"JPY"}',
            ]]
        ];
    }

    /**
     * @dataProvider ReadDataProvider
     * @covers JsonTextReader::read
     */
    public function testReadSuccess(array $jsonStrings): void
    {
        $i = 0;
        foreach ($this->reader->read() as $result) {
            $expected = json_decode($jsonStrings[$i++], true);
            $this->assertEquals($expected, $result);
        }
    }

    /**
     * @covers JsonTextReader::read
     */
    public function testReadFail(): void
    {
        $result = $this->reader->read()->next();
        $this->assertNull($result);
    }
}