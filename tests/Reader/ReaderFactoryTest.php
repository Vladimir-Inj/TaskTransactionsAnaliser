<?php

use Application\Exception\ReaderException;
use Application\Reader\JsonTextReader;
use Application\Reader\ReaderFactory;
use PHPUnit\Framework\TestCase;

class ReaderFactoryTest extends TestCase
{
    private CONST TXT_FILE_NAME = 'jsonText.txt';
    private CONST TXT_FILE_CONTENT = <<<END
{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
{"bin":"45417360","amount":"10000.00","currency":"JPY"}
END;

    private CONST XML_FILE_NAME = 'jsonText.xml';
    private CONST XML_FILE_CONTENT = <<<END
<transactions>
    <transaction>
        <bin>45717360</bin>
        <amount>100.00</amount>
        <currency>USD</currency>
    </transaction>
</transactions>
END;

    private CONST NON_EXISTS_FILE_NAME = 'non_exists.abc';

    protected function setUp(): void
    {
        file_put_contents(self::TXT_FILE_NAME, self::TXT_FILE_CONTENT);
        file_put_contents(self::XML_FILE_NAME, self::XML_FILE_CONTENT);
    }

    protected function tearDown(): void
    {
        unlink(self::TXT_FILE_NAME);
        unlink(self::XML_FILE_NAME);
    }

    /**
     * @covers ReaderFactory::getReader
     */
    public function testGetJsonTextReader(): void
    {
        $this->assertInstanceOf(JsonTextReader::class, ReaderFactory::getReader(self::TXT_FILE_NAME));
    }

    /**
     * @covers ReaderFactory::getReader
     */
    public function testReaderNonExists(): void
    {
        $this->expectException(ReaderException::class);
        ReaderFactory::getReader(self::XML_FILE_NAME);
    }

    /**
     * @covers ReaderFactory::getReader
     */
    public function testFileNonExists(): void
    {
        $this->expectException(ReaderException::class);
        ReaderFactory::getReader(self::NON_EXISTS_FILE_NAME);
    }
}