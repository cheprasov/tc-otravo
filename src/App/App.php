<?php

namespace TC\Otravo\App;

use TC\Otravo\Request\RequestFactory;
use TC\Otravo\Response\ResponseFactory;
use TC\Otravo\Show\Helper;

class App
{
    protected static function isCliMode(): bool
    {
        return PHP_SAPI === 'cli';
    }

    public function run()
    {
        $Response = ResponseFactory::create(self::isCliMode());
        $Request = RequestFactory::create(self::isCliMode());
        try {
            $result = Helper::getResult(
                $Request->getFilename(),
                $Request->getDateQuery(),
                $Request->getDateShow(),
                $Request->getWithPrice()
            );
            $Response->setMessage($result);
        } catch (\Exception $Ex) {
            $Response->setMessage($Ex->getMessage());
        }

        $Response->echoMessage();
    }
}
