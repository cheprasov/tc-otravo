<?php

namespace TC\Otravo\Request;

class RequestFactory
{
    public static function create(bool $isCliMode): RequestInterface
    {
        if ($isCliMode) {
            return new CliRequest();
        }
        return new WebRequest();
    }
}
