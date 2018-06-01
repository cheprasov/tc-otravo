<?php

namespace TC\Otravo\Show\Ticket;

use TC\Otravo\Show\Entity\ShowInterface;

interface TicketManagerInterface
{
    /**
     * @param ShowInterface $Show
     * @param \DateTime $DateQuery
     * @param \DateTime $DateShow
     * @return TicketInfo
     */
    public function getTicketInfo(ShowInterface $Show, \DateTime $DateQuery, \DateTime $DateShow): TicketInfo;
}
