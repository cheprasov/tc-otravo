<?php

namespace TC\Otravo\Show\Ticket\Discount;

use TC\Otravo\Show\Entity\ShowInterface;

interface DiscountInterface
{
    public function getDiscount(ShowInterface $Show, \DateTime $DateShow): int;
}
