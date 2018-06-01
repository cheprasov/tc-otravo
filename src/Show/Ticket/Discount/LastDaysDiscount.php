<?php

namespace TC\Otravo\Show\Ticket\Discount;

use TC\Otravo\Show\Entity\ShowInterface;

class LastDaysDiscount implements DiscountInterface
{
    /**
     * % discount
     * @var int
     */
    protected $discount;

    /**
     * @var int
     */
    protected $lastDaysCount;

    /**
     * @param int $lastDaysCount
     * @param int $discount
     */
    public function __construct(int $lastDaysCount = 20, int $discount = 20)
    {
        $this->lastDaysCount = $lastDaysCount;
        $this->discount = $discount;
    }

    protected function getDateInterval(): \DateInterval
    {
        return new \DateInterval('P' . ($this->lastDaysCount - 1) . 'D');
    }

    /**
     * @param ShowInterface $Show
     * @param \DateTime $DateShow
     * @return float
     */
    public function getDiscount(ShowInterface $Show, \DateTime $DateShow): int
    {
        $DateBegDiscount = clone $Show->getDateEnd();
        $DateBegDiscount->sub($this->getDateInterval());

        if ($DateShow->getTimestamp() >= $DateBegDiscount->getTimestamp()
            && $DateShow->getTimestamp() <= $Show->getDateEnd()->getTimestamp()
            ) {
            return $this->discount;
        }

        return 0;
    }
}
