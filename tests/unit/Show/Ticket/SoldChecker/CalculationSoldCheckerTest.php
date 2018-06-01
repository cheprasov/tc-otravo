<?php

use TC\Otravo\Show\Ticket\TicketInfo;
use TC\Otravo\Show\Ticket\SoldChecker\CalculationSoldChecker;
use TC\Otravo\Show\Entity\DramaShow;

class CalculationSoldCheckerTest extends \PHPUnit\Framework\TestCase
{
    public function providerUpdateTicketInfo()
    {
        return [
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2017-08-01',
                'showEnd' => '2018-08-31',
                'dateQuery' => '2017-08-01',
                'dateShow' => '2017-08-15',
                'daysForSale' => 25,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                    'sold' => 100,
                    'available' => 10,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-03-21',
                'dateShow' => '2018-03-21',
                'daysForSale' => 25,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_SOLD_OUT,
                    'sold' => 200,
                    'available' => 0,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-03-29',
                'dateShow' => '2018-03-30',
                'daysForSale' => 1,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                    'sold' => 0,
                    'available' => 10,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-03-29',
                'dateShow' => '2018-03-30',
                'daysForSale' => 2,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                    'sold' => 0,
                    'available' => 10,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-03-30',
                'dateShow' => '2018-03-30',
                'daysForSale' => 2,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                    'sold' => 10,
                    'available' => 10,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-03-26',
                'dateShow' => '2018-03-30',
                'daysForSale' => 5,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                    'sold' => 0,
                    'available' => 10,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-03-27',
                'dateShow' => '2018-03-30',
                'daysForSale' => 5,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                    'sold' => 10,
                    'available' => 10,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-03-28',
                'dateShow' => '2018-03-30',
                'daysForSale' => 5,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                    'sold' => 20,
                    'available' => 10,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-03-05',
                'dateShow' => '2018-03-30',
                'daysForSale' => 25,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                    'sold' => 0,
                    'available' => 10,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-03-07',
                'dateShow' => '2018-03-30',
                'daysForSale' => 25,
                'capacity' => 200,
                'available' => 10,
                'expect' => [
                    'status' => TicketInfo::STATUS_OPEN_FOR_SALE,
                    'sold' => 10,
                    'available' => 10,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_SALE_NOT_STARTED,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-01-01',
                'dateShow' => '2018-03-30',
                'daysForSale' => 25,
                'capacity' => 200,
                'available' => 0,
                'expect' => [
                    'status' => TicketInfo::STATUS_SALE_NOT_STARTED,
                    'sold' => 0,
                    'available' => 0,
                ],
            ],
            'line_' . __LINE__ => [
                'status' => TicketInfo::STATUS_IN_THE_PAST,
                'showBeg' => '2018-03-01',
                'showEnd' => '2018-05-31',
                'dateQuery' => '2018-04-01',
                'dateShow' => '2018-03-01',
                'daysForSale' => 25,
                'capacity' => 200,
                'available' => 0,
                'expect' => [
                    'status' => TicketInfo::STATUS_IN_THE_PAST,
                    'sold' => 200,
                    'available' => 0,
                ],
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Show\Ticket\SoldChecker\CalculationSoldChecker::updateTicketInfo
     * @dataProvider providerUpdateTicketInfo
     */
    public function testUpdateTicketInfo(
        $status, $showBeg, $showEnd, $dateQuery, $dateShow, $daysForSale, $capacity, $available, $expect
    )
    {
        $Show = new DramaShow('Cats', new \DateTime($showBeg), new \DateTime($showEnd));
        $TicketInfo = new TicketInfo($Show, new \DateTime($dateQuery), new \DateTime($dateShow));
        $TicketInfo->setStatus($status);
        $TicketInfo->setHallСapacity($capacity);
        $TicketInfo->setAvailableForSale($available);

        $SoldChecker = new CalculationSoldChecker($daysForSale);
        $SoldChecker->updateTicketInfo($TicketInfo);

        $this->assertSame($expect['status'], $TicketInfo->getStatus(), 'Wrong status');
        $this->assertSame($expect['sold'], $TicketInfo->getSoldCount(), 'Wrong sold count');
        $this->assertSame($expect['available'], $TicketInfo->getAvailableForSale(), 'Wrong available count');
    }
}
