<?php

use TC\Otravo\Show\Entity\DramaShow;
use \TC\Otravo\Show\Ticket\TicketInfo;

class TicketInfoTest extends \PHPUnit\Framework\TestCase
{
    public function providerToArray()
    {
        return [
            'line_' . __LINE__ => [
                'title' => 'Cats',
                'capacity' => 200,
                'available' => 10,
                'sold' => 40,
                'status' => 'open for sale',
                'price' => '77.00',
                'expect' => [
                    'title' => 'Cats',
                    'tickets left' => 160,
                    'tickets available' => 10,
                    'status' => 'open for sale',
                    'price' => '77.00',
                ],
            ],
            'line_' . __LINE__ => [
                'title' => 'Dogs',
                'capacity' => 100,
                'available' => 5,
                'sold' => 20,
                'status' => 'some status',
                'price' => null,
                'expect' => [
                    'title' => 'Dogs',
                    'tickets left' => 80,
                    'tickets available' => 5,
                    'status' => 'some status',
                ],
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Show\Ticket\TicketInfo::toArray
     * @dataProvider providerToArray
     */
    public function testToArray($title, $capacity, $available, $sold, $status, $price, $expect)
    {
        $Show = new DramaShow($title, new \DateTime('2018-10-10'), new \DateTime('2018-12-10'));
        $TicketInfo = new TicketInfo($Show, new \DateTime('2018-10-10'), new \DateTime('2018-10-10'));
        $TicketInfo->setHallСapacity($capacity);
        $TicketInfo->setAvailableForSale($available);
        $TicketInfo->setStatus($status);
        $TicketInfo->setSoldCount($sold);
        if (!is_null($price)) {
            $TicketInfo->setPrice($price);
        }
        $result = $TicketInfo->toArray();
        $this->assertSame($expect, $result);
    }
}
