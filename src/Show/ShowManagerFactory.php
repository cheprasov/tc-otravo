<?php

namespace TC\Otravo\Show;

use TC\Otravo\Show\Storage\CSVStorage;
use TC\Otravo\Show\Ticket\SoldChecker\CalculationSoldChecker;
use TC\Otravo\Show\Ticket\Discount\LastDaysDiscount;
use TC\Otravo\Show\Ticket\TicketManager;

class ShowManagerFactory
{
    public static function create(string $filename, $withPrice): ShowManager
    {
        $CSVStorage = new CSVStorage($filename);
        $TicketManager = new TicketManager(
            new CalculationSoldChecker(TicketManager::DAYS_COUNT_FOR_SALE_BEFORE_SHOW),
            new LastDaysDiscount(),
            $withPrice
        );
        $ShowManager = new ShowManager($CSVStorage, $TicketManager);
        return $ShowManager;
    }
}
