<?php

use Application\Request\CliRequest;
use Application\Request\HttpRequest;
use Application\Request\RequestFactory;
use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    /**
     * @covers RequestFactory::getRequest
     */
    public function testGetHttpRequest(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/';
        $this->assertInstanceOf(HttpRequest::class, RequestFactory::getRequest());
    }

    /**
     * @covers ReaderFactory::getReader
     */
    public function testGetCliRequest(): void
    {
        unset($_SERVER['REQUEST_METHOD']);
        $this->assertInstanceOf(CliRequest::class, RequestFactory::getRequest());
    }
}