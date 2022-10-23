<?php
declare(strict_types = 1);

namespace Application\Request;

class HttpRequest extends AbstractRequest
{
    public function init(): void
    {
        $this->properties = $_REQUEST;
    }
}
