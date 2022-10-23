<?php

use Application\Config;
use Application\Exception\ConfigException;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    private ?Config $config;
    private CONST FILE_NON_EXISTS = 'non_exists.ini';

    private CONST FILE_NAME = 'config.ini';
    private CONST FILE_CONTENT = <<<END
currency_rates_source = 'exchangerates'

[commission_rates]
eu = 0.01
not_eu = 0.02
END;

    protected function setUp(): void
    {
        file_put_contents(self::FILE_NAME, self::FILE_CONTENT);
        $this->config = new Config(self::FILE_NAME);
    }

    protected function tearDown(): void
    {
        $this->config = null;
        unlink(self::FILE_NAME);
    }

    /**
     * @covers Config::__construct
     */
    public function testNonExistsConfig(): void
    {
        $this->expectException(ConfigException::class);
        new Config(self::FILE_NON_EXISTS);
    }

    /**
     * @covers Config::get
     */
    public function testGetFromInitFile(): void
    {
        $this->assertEquals('exchangerates', $this->config->get('currency_rates_source'));
        $this->assertEquals(['eu' => 0.01, 'not_eu' => 0.02], $this->config->get('commission_rates'));
    }

    public function GetAndSetDataProvider(): array
    {
        return [
            ['val1', 111111],
            ['val2', ['333333', -35, 'EUR', -345, 4]],
            ['val3', null],
        ];
    }

    /**
     * @dataProvider GetAndSetDataProvider
     * @covers Config::get
     * @covers Config::set
     */
    public function testGetAndSet(string $key, $value): void
    {
        $this->config->set($key, $value);
        $this->assertEquals($value, $this->config->get($key));
    }
}