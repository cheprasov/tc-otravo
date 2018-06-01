<?php

namespace TC\Otravo\Show\Ticket\SoldChecker;

use TC\Otravo\Show\Ticket\TicketInfo;

interface SoldCheckerInterface
{
    public function updateTicketInfo(TicketInfo $TicketInfo): bool;
}
