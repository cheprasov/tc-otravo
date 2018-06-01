<?php

use TC\Otravo\Show\Ticket\TicketManager;
use TC\Otravo\Show\Ticket\TicketInfo;
use TC\Otravo\Show\Entity\ShowFactory;
use TC\Otravo\Show\Ticket\Discount\LastDaysDiscount;
use TC\Otravo\Show\Ticket\SoldChecker\CalculationSoldChecker;

class TicketManagerTest extends \PHPUnit\Framework\TestCase
{
    public function providerUpdateTicketInfoStatus()
    {
        return [
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-31',
                'dateQuery' => '2017-05-01',
                'dateShow'  => '2017-05-31',
                'expect' => TicketInfo::STATUS_SALE_NOT_STARTED,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-31',
                'dateQuery' => '2017-05-05',
                'dateShow'  => '2017-05-31',
                'expect' => TicketInfo::STATUS_SALE_NOT_STARTED,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-31',
                'dateQuery' => '2017-05-06',
                'dateShow'  => '2017-05-31',
                'expect' => TicketInfo::STATUS_OPEN_FOR_SALE,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-31',
                'dateQuery' => '2017-06-04',
                'dateShow'  => '2017-06-30',
                'expect' => TicketInfo::STATUS_SALE_NOT_STARTED,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-31',
                'dateQuery' => '2017-06-05',
                'dateShow'  => '2017-06-30',
                'expect' => TicketInfo::STATUS_OPEN_FOR_SALE,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-31',
                'dateQuery' => '2017-06-05',
                'dateShow'  => '2017-12-30',
                'expect' => TicketInfo::STATUS_IN_THE_PAST,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-15',
                'dateQuery' => '2017-05-30',
                'dateShow'  => '2017-05-15',
                'expect' => TicketInfo::STATUS_IN_THE_PAST,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-30',
                'dateQuery' => '2017-05-04',
                'dateShow'  => '2017-05-04',
                'expect' => TicketInfo::STATUS_IN_THE_PAST,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-30',
                'dateQuery' => '2017-05-28',
                'dateShow'  => '2017-05-29',
                'expect' => TicketInfo::STATUS_IN_THE_PAST,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-30',
                'dateQuery' => '2017-12-28',
                'dateShow'  => '2017-12-28',
                'expect' => TicketInfo::STATUS_IN_THE_PAST,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-30',
                'dateQuery' => '2017-05-20',
                'dateShow'  => '2017-05-30',
                'expect' => TicketInfo::STATUS_OPEN_FOR_SALE,
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Show\Ticket\TicketManager::updateTicketInfoStatus
     * @dataProvider providerUpdateTicketInfoStatus
     */
    public function testUpdateTicketInfoStatus($dateBegin, $dateQuery, $dateShow, $expect)
    {
        $Show = ShowFactory::create('cats', $dateBegin, 'drama');
        $TicketInfo = new TicketInfo($Show, new \DateTime($dateQuery), new \DateTime($dateShow));

        $TicketManagerMock = $this->getMockBuilder(TicketManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $ReflectionMethod = new ReflectionMethod(get_class($TicketManagerMock), 'updateTicketInfoStatus');
        $ReflectionMethod->setAccessible(true);
        $ReflectionMethod->invoke($TicketManagerMock, $TicketInfo);

        $this->assertSame($expect, $TicketInfo->getStatus());
    }

    public function providerIsShowInBigHall()
    {
        return [
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-15',
                'dateShow'  => '2017-06-15',
                'countDaysInBigHall' => 60,
                'expect' => true,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-15',
                'dateShow'  => '2017-05-15',
                'countDaysInBigHall' => 1,
                'expect' => true,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-15',
                'dateShow'  => '2017-05-16',
                'countDaysInBigHall' => 1,
                'expect' => false,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-15',
                'dateShow'  => '2017-05-16',
                'countDaysInBigHall' => 3,
                'expect' => true,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-15',
                'dateShow'  => '2017-05-17',
                'countDaysInBigHall' => 3,
                'expect' => true,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-15',
                'dateShow'  => '2017-05-18',
                'countDaysInBigHall' => 3,
                'expect' => false,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-15',
                'dateShow'  => '2017-05-19',
                'countDaysInBigHall' => 3,
                'expect' => false,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-01',
                'dateShow'  => '2017-05-10',
                'countDaysInBigHall' => 10,
                'expect' => true,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-01',
                'dateShow'  => '2017-05-11',
                'countDaysInBigHall' => 10,
                'expect' => false,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-01',
                'dateShow'  => '2017-05-30',
                'countDaysInBigHall' => 30,
                'expect' => true,
            ],
            'line_' . __LINE__ => [
                'dateBegin' => '2017-05-01',
                'dateShow'  => '2017-05-31',
                'countDaysInBigHall' => 30,
                'expect' => false,
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Show\Ticket\TicketManager::isShowInBigHall
     * @dataProvider providerIsShowInBigHall
     */
    public function testIsShowInBigHall($dateBegin, $dateShow, $countDaysInBigHall, $expect)
    {
        $Show = ShowFactory::create('cats', $dateBegin, 'drama');

        $TicketManagerMock = $this->getMockBuilder(TicketManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCountDaysInBigHall'])
            ->getMock();

        $TicketManagerMock->expects($this->once())
            ->method('getCountDaysInBigHall')
            ->willReturn($countDaysInBigHall);

        $ReflectionMethod = new ReflectionMethod(get_class($TicketManagerMock), 'isShowInBigHall');
        $ReflectionMethod->setAccessible(true);
        $result = $ReflectionMethod->invoke($TicketManagerMock, $Show, new \DateTime($dateShow));
        $this->assertSame($expect, $result);
    }

    public function providerUpdateTicketInfoPrice()
    {
        return [
            'line_' . __LINE__ => [
                'discount' => 0,
                'type' => 'drama',
                'expect' => '40.00'
            ],
            'line_' . __LINE__ => [
                'discount' => 10,
                'type' => 'drama',
                'expect' => '36.00'
            ],
            'line_' . __LINE__ => [
                'discount' => 20,
                'type' => 'drama',
                'expect' => '32.00'
            ],
            'line_' . __LINE__ => [
                'discount' => 25,
                'type' => 'drama',
                'expect' => '30.00'
            ],
            'line_' . __LINE__ => [
                'discount' => 50,
                'type' => 'drama',
                'expect' => '20.00'
            ],
            'line_' . __LINE__ => [
                'discount' => 75,
                'type' => 'drama',
                'expect' => '10.00'
            ],
            'line_' . __LINE__ => [
                'discount' => 100,
                'type' => 'drama',
                'expect' => '0.00'
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Show\Ticket\TicketManager::updateTicketInfoPrice
     * @dataProvider providerUpdateTicketInfoPrice
     */
    public function testUpdateTicketInfoPrice($discount, $type, $expect)
    {
        $Show = ShowFactory::create('cats', '2017-10-10', $type);
        $TicketInfo = new TicketInfo($Show, new \DateTime('2017-10-10'), new \DateTime('2017-10-10'));

        $SoldCheckerMock = $this->getMockBuilder(CalculationSoldChecker::class)
            ->disableOriginalConstructor()
            ->getMock();

        $DiscountMock = $this->getMockBuilder(LastDaysDiscount::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDiscount'])
            ->getMock();

        $DiscountMock->expects($this->once())
            ->method('getDiscount')
            ->willReturn($discount);

        $TicketManager = new TicketManager($SoldCheckerMock, $DiscountMock);

        $ReflectionMethod = new ReflectionMethod(get_class($TicketManager), 'updateTicketInfoPrice');
        $ReflectionMethod->setAccessible(true);
        $ReflectionMethod->invoke($TicketManager, $TicketInfo);

        $this->assertSame($expect, $TicketInfo->getPrice());
    }
}
