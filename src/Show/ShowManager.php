<?php

namespace TC\Otravo\Show;

use TC\Otravo\Show\Entity\ShowInterface;
use TC\Otravo\Show\Storage\StorageInterface;
use TC\Otravo\Show\Ticket\TicketInfo;
use TC\Otravo\Show\Ticket\TicketManager;

class ShowManager
{
    const SHOW_DAYS_COUNT = 100; // days

    /**
     * @var StorageInterface
     */
    protected $Storage;

    /**
     * @var TicketManager
     */
    protected $TicketManager;

    /**
     * @param StorageInterface $Storage
     * @param TicketManager $TicketManager
     */
    public function __construct(StorageInterface $Storage, TicketManager $TicketManager)
    {
        $this->Storage = $Storage;
        $this->TicketManager = $TicketManager;
    }

    /**
     * @param \DateTime $DateQuery
     * @param \DateTime $DateShow
     * @return Inventory
     */
    public function getInventory(\DateTime $DateQuery, \DateTime $DateShow): Inventory
    {
        $Inventory = new Inventory();

        $shows = $this->Storage->getAll($DateShow);
        foreach ($shows as $Show) {
            $TicketInfo = $this->getTicketInfo($Show, $DateQuery, $DateShow);
            $Inventory->add($TicketInfo);
        }

        return $Inventory;
    }

    /**
     * @param ShowInterface $Show
     * @param \DateTime $DateQuery
     * @param \DateTime $DateShow
     * @return TicketInfo
     */
    protected function getTicketInfo(ShowInterface $Show, \DateTime $DateQuery, \DateTime $DateShow): TicketInfo
    {
        $TicketInfo = $this->TicketManager->getTicketInfo($Show, $DateQuery, $DateShow);
        return $TicketInfo;
    }
}
