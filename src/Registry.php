<?php
declare(strict_types = 1);

namespace Application;

use Application\Exception\AppException;
use Application\Request\AbstractRequest;

class Registry
{
    private static ?self $instance = null;
    private ?AbstractRequest $request = null;
    private ?Config $config = null;

    private function __construct()
    {
    }

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function reset(): void
    {
        self::$instance = null;
    }

    // must be initialized by some smarter component
    public function setRequest(AbstractRequest $request): void
    {
        $this->request = $request;
    }

    public function getRequest(): AbstractRequest
    {
        if (is_null($this->request)) {
            throw new AppException("No Request set");
        }

        return $this->request;
    }

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function getConfig(): Config
    {
        if (is_null($this->request)) {
            throw new AppException("No Config set");
        }

        return $this->config;
    }
}
