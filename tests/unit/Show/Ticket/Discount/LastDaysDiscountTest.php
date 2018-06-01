<?php

use TC\Otravo\Show\Ticket\Discount\LastDaysDiscount;
use TC\Otravo\Show\Entity\DramaShow;

class LastDaysDiscountTest extends \PHPUnit\Framework\TestCase
{
    public function providerGetDiscount()
    {
        return [
            'line_' . __LINE__ => [
                'dateBeg' => '2018-01-01',
                'dateEnd' => '2018-01-31',
                'showDate' => '2018-01-01',
                'interval' => 1,
                'discount' => 20,
                'expect' => 0,
            ],
            'line_' . __LINE__ => [
                'dateBeg' => '2018-01-01',
                'dateEnd' => '2018-01-31',
                'showDate' => '2018-01-31',
                'interval' => 1,
                'discount' => 20,
                'expect' => 20,
            ],
            'line_' . __LINE__ => [
                'dateBeg' => '2018-01-01',
                'dateEnd' => '2018-01-31',
                'showDate' => '2018-01-30',
                'interval' => 1,
                'discount' => 20,
                'expect' => 0,
            ],
            'line_' . __LINE__ => [
                'dateBeg' => '2018-01-01',
                'dateEnd' => '2018-01-15',
                'showDate' => '2018-01-10',
                'interval' => 5,
                'discount' => 20,
                'expect' => 0,
            ],
            'line_' . __LINE__ => [
                'dateBeg' => '2018-01-01',
                'dateEnd' => '2018-01-15',
                'showDate' => '2018-01-11',
                'interval' => 5,
                'discount' => 10,
                'expect' => 10,
            ],
            'line_' . __LINE__ => [
                'dateBeg' => '2018-01-01',
                'dateEnd' => '2018-01-30',
                'showDate' => '2018-01-10',
                'interval' => 20,
                'discount' => 20,
                'expect' => 0,
            ],
            'line_' . __LINE__ => [
                'dateBeg' => '2018-01-01',
                'dateEnd' => '2018-01-30',
                'showDate' => '2018-01-11',
                'interval' => 20,
                'discount' => 20,
                'expect' => 20,
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Show\Ticket\Discount\Last20DaysDiscount::getDiscount
     * @dataProvider providerGetDiscount
     */
    public function testGetDiscount($dateBeg, $dateEnd, $showDate, $interval, $discount, $expect)
    {
        $Discount = new LastDaysDiscount($interval, $discount);
        $Show = new DramaShow('Cats', new \DateTime($dateBeg), new \DateTime($dateEnd));
        $result = $Discount->getDiscount($Show, new \DateTime($showDate));
        $this->assertSame($expect, $result);
    }
}
