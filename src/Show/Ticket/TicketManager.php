<?php

namespace TC\Otravo\Show\Ticket;

use TC\Otravo\Exception\Exception;
use TC\Otravo\Show\Entity\ShowInterface;
use TC\Otravo\Show\Ticket\SoldChecker\SoldCheckerInterface;
use TC\Otravo\Show\Ticket\Discount\DiscountInterface;

class TicketManager implements TicketManagerInterface
{
    const DAYS_COUNT_FOR_SALE_BEFORE_SHOW = 25;

    const DAYS_COUNT_IN_BIG_HALL = 60;

    const TICKETS_COUNT_BIG_HALL = 200;
    const TICKETS_COUNT_SMALL_HALL = 100;

    const TICKETS_FOR_SALE_BIG_HALL = 10;
    const TICKETS_FOR_SALE_SMALL_HALL = 5;

    const MAP_SHOW_TYPE_TO_PRICE = [
        ShowInterface::TYPE_DRAMA => 40,
        ShowInterface::TYPE_COMEDY => 50,
        ShowInterface::TYPE_MUSICAL => 70,
    ];

    /**
     * @var SoldCheckerInterface
     */
    protected $SoldChecker;

    /**
     * @var DiscountInterface|null
     */
    protected $Discount;

    /**
     * @var bool
     */
    protected $withPrice;

    /**
     * @param SoldCheckerInterface $Checker
     * @param DiscountInterface|null $Discount
     * @param $withPrice $Discount
     */
    public function __construct(SoldCheckerInterface $Checker, DiscountInterface $Discount = null, $withPrice = false)
    {
        $this->SoldChecker = $Checker;
        $this->Discount = $Discount;
        $this->withPrice = $withPrice;
    }

    /**
     * @return int
     */
    protected function getCountDaysInBigHall(): int
    {
        return self::DAYS_COUNT_IN_BIG_HALL;
    }

    /**
     * @param ShowInterface $Show
     * @param \DateTime $DateShow
     * @return bool
     */
    protected function isShowInBigHall(ShowInterface $Show, \DateTime $DateShow): bool
    {
        $DateInterval = date_diff($Show->getDateBeg(), $DateShow);
        $days = (int)$DateInterval->format('%r%a');
        if ($days > $this->getCountDaysInBigHall() - 1) {
            return false;
        }
        return true;
    }

    /**
     * @param TicketInfo $TicketInfo
     * @return bool
     */
    protected function updateTicketInfoStatus(TicketInfo $TicketInfo): bool
    {
        $Show = $TicketInfo->getShow();
        $DateShow = $TicketInfo->getDateShow();
        $DateQuery = $TicketInfo->getDateQuery();

        if ($DateShow->getTimestamp() < $DateQuery->getTimestamp()
            || $DateShow->getTimestamp() > $Show->getDateEnd()->getTimestamp()
            || $DateShow->getTimestamp() < $Show->getDateBeg()->getTimestamp()
            || $DateQuery->getTimestamp() > $Show->getDateEnd()->getTimestamp()
        ) {
            $TicketInfo->setStatus(TicketInfo::STATUS_IN_THE_PAST);
            $TicketInfo->setAvailableForSale(0);
            return true;
        }

        $days = (int)date_diff($DateQuery, $DateShow)->format('%r%a');
        if ($days > self::DAYS_COUNT_FOR_SALE_BEFORE_SHOW) {
            $TicketInfo->setStatus(TicketInfo::STATUS_SALE_NOT_STARTED);
            $TicketInfo->setAvailableForSale(0);
            return true;
        }

        $TicketInfo->setStatus(TicketInfo::STATUS_OPEN_FOR_SALE);
        return true;
    }

    /**
     * @param TicketInfo $TicketInfo
     * @return bool
     * @throws Exception
     */
    protected function updateTicketInfoPrice(TicketInfo $TicketInfo): bool
    {
        $price = self::MAP_SHOW_TYPE_TO_PRICE[$TicketInfo->getShow()->getType()] ?? null;
        if (!$price) {
            throw new Exception('Cant find price for typeId: ' . $TicketInfo->getShow()->getType());
        }

        if ($this->Discount) {
            $discount = $this->Discount->getDiscount($TicketInfo->getShow(), $TicketInfo->getDateShow());
        } else {
            $discount = 0;
        }

        // Use BCMath because we work with money
        bcscale(2);
        if ($discount) {
            // price = price - price * (discount / 100);
            $price = bcsub($price, bcmul($price, bcdiv($discount, 100)));
        } else {
            $price = bcadd($price, 0);
        }
        $TicketInfo->setPrice($price);
        return true;
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getTicketInfo(ShowInterface $Show, \DateTime $DateQuery, \DateTime $DateShow): TicketInfo
    {
        $TicketInfo = new TicketInfo($Show, $DateQuery, $DateShow);

        $isBigHall = $this->isShowInBigHall($Show, $DateShow);

        $TicketInfo->setHallСapacity($isBigHall ? self::TICKETS_COUNT_BIG_HALL : self::TICKETS_COUNT_SMALL_HALL);
        $TicketInfo->setAvailableForSale($isBigHall ? self::TICKETS_FOR_SALE_BIG_HALL : self::TICKETS_FOR_SALE_SMALL_HALL);

        $this->updateTicketInfoStatus($TicketInfo);
        if ($this->withPrice) {
            $this->updateTicketInfoPrice($TicketInfo);
        }
        $this->SoldChecker->updateTicketInfo($TicketInfo);

        return $TicketInfo;
    }
}
