<?php
declare(strict_types = 1);

namespace Application\Request;

class RequestFactory
{
    public static function getRequest(): AbstractRequest
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $request = new HttpRequest();
        } else {
            $request = new CliRequest();
        }

        return $request;
    }
}