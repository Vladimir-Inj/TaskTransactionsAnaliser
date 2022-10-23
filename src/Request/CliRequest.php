<?php
declare(strict_types = 1);

namespace Application\Request;

class CliRequest extends AbstractRequest
{
    public function init(): void
    {
        $args = $_SERVER['argv'];
        foreach ($args as $arg) {
            if (strpos($arg, '=')) {
                list($key, $val) = explode("=", $arg);
                $this->setProperty($key, $val);
            }
        }
    }
}
