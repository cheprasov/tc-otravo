<?php

namespace TC\Otravo\Show\Ticket\SoldChecker;

use TC\Otravo\Show\Ticket\TicketInfo;

class CalculationSoldChecker implements SoldCheckerInterface
{
    /**
     * @var int
     */
    protected $daysCountForSaleBeforeShow;

    /**
     * @param int $daysCountForSaleBeforeShow
     */
    public function __construct(int $daysCountForSaleBeforeShow)
    {
        $this->daysCountForSaleBeforeShow = $daysCountForSaleBeforeShow;
    }

    public function updateTicketInfo(TicketInfo $TicketInfo): bool
    {
        $hallCapacity = $TicketInfo->getHallСapacity();
        $availableForSale = $TicketInfo->getAvailableForSale();

        if (TicketInfo::STATUS_IN_THE_PAST === $TicketInfo->getStatus()) {
            $TicketInfo->setSoldCount($hallCapacity);
            return true;
        }

        if (TicketInfo::STATUS_SALE_NOT_STARTED === $TicketInfo->getStatus()) {
            $TicketInfo->setSoldCount(0);
            return true;
        }

        $SaleDate = clone $TicketInfo->getDateShow();
        $SaleDate->sub(new \DateInterval('P' . $this->daysCountForSaleBeforeShow  . 'D'));
        $days = (int)date_diff($SaleDate, $TicketInfo->getDateQuery())->format('%r%a');
        $sold = min(max(0, $days - 1) * $availableForSale, $hallCapacity);

        if ($sold === $hallCapacity) {
            $TicketInfo->setStatus(TicketInfo::STATUS_SOLD_OUT);
            $TicketInfo->setAvailableForSale(0);
        }
        $TicketInfo->setSoldCount($sold);
        return true;
    }
}
