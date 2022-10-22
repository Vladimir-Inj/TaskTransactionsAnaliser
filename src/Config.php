<?php
declare(strict_types = 1);

namespace Application;

use Application\Exception\ConfigException;

class Config
{
    private array $values;

    public function __construct(string $configFile)
    {
        if (! file_exists($configFile)) {
            throw new ConfigException('Could not find config file ' . $configFile);
        }

        $this->values = parse_ini_file($configFile, true);
    }

    public function get(string $key): null|string|float|array|int
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    public function set(string $key, $value): void
    {
        $this->values[$key] = $value;
    }
}
