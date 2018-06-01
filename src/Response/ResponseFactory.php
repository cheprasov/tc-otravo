<?php

namespace TC\Otravo\Response;

class ResponseFactory
{
    /**
     * @param bool $isCliMode
     * @return ResponseInterface
     */
    public static function create(bool $isCliMode): ResponseInterface
    {
        if ($isCliMode) {
            return new CliResponse();
        }
        return new WebResponse();
    }
}
