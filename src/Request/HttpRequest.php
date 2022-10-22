<?php
declare(strict_types = 1);

namespace Application\Request;

class HttpRequest extends AbstractRequest
{
    public function init(): void
    {
        $this->properties = $_REQUEST;
        $this->path = $_SERVER['PATH_INFO'];
        $this->path = (empty($this->path)) ? "/" : $this->path;
    }
}
