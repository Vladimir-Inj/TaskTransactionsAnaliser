<?php
declare(strict_types = 1);

namespace Application\Request;

class CliRequest extends AbstractRequest
{
    public function init(): void
    {
        $args = $_SERVER['argv'];
        foreach ($args as $arg) {
            if (preg_match("/^path:(\S+)/", $arg, $matches)) {
                $this->path = $matches[1];
            } elseif (strpos($arg, '=')) {
                list($key, $val) = explode("=", $arg);
                $this->setProperty($key, $val);
            }
        }

        $this->path = (empty($this->path)) ? "/" : $this->path;
    }
}
