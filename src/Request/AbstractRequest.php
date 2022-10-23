<?php
declare(strict_types = 1);

namespace Application\Request;

abstract class AbstractRequest
{
    protected array $properties;

    public function __construct()
    {
        $this->init();
    }

    abstract public function init(): void;

    public function getProperty(string $key)
    {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }

        return null;
    }

    public function setProperty(string $key, $val): void
    {
        $this->properties[$key] = $val;
    }
}
