<?php

use TC\Otravo\Show\Ticket\TicketInfo;
use TC\Otravo\Show\Inventory;
use TC\Otravo\Show\Entity\ShowInterface;
use TC\Otravo\Show\Entity\ShowFactory;

class InventoryTest extends \PHPUnit\Framework\TestCase
{
    protected function getTicketInfoMock($title, $type)
    {
        $Show = ShowFactory::create($title, '2018-10-10', $type);

        /** @var \PHPUnit\Framework\MockObject\MockObject|TicketInfo $TicketInfoMock */
        $TicketInfoMock = $this->getMockBuilder(TicketInfo::class)
            ->setConstructorArgs([$Show, new \DateTime(), new \DateTime()])
            ->setMethods(['toArray'])
            ->getMock();

        $TicketInfoMock->expects($this->any())
            ->method('toArray')
            ->willReturn([$title]);

        return $TicketInfoMock;
    }

    /**
     * @see \TC\Otravo\Show\Inventory::toArray
     */
    public function testToArray()
    {
        $Inventory = new Inventory();
        $this->assertSame(['inventory' => []], $Inventory->toArray());

        $Inventory->add($this->getTicketInfoMock('Cats', ShowInterface::TYPE_DRAMA));
        $this->assertSame(
            [
                'inventory' => [
                    [
                        'genre' => 'drama',
                        'shows' => [
                            ['Cats'],
                        ],
                    ],
                ]
            ],
            $Inventory->toArray()
        );

        $Inventory->add($this->getTicketInfoMock('Dogs', ShowInterface::TYPE_DRAMA));
        $this->assertSame(
            [
                'inventory' => [
                    [
                        'genre' => 'drama',
                        'shows' => [
                            ['Cats'],
                            ['Dogs'],
                        ],
                    ],
                ]
            ],
            $Inventory->toArray()
        );

        $Inventory->add($this->getTicketInfoMock('Mice', ShowInterface::TYPE_COMEDY));
        $this->assertSame(
            [
                'inventory' => [
                    [
                        'genre' => 'comedy',
                        'shows' => [
                            ['Mice'],
                        ],
                    ],
                    [
                        'genre' => 'drama',
                        'shows' => [
                            ['Cats'],
                            ['Dogs'],
                        ],
                    ],
                ]
            ],
            $Inventory->toArray()
        );

        $Inventory->add($this->getTicketInfoMock('Deer', ShowInterface::TYPE_MUSICAL));
        $this->assertSame(
            [
                'inventory' => [
                    [
                        'genre' => 'musical',
                        'shows' => [
                            ['Deer'],
                        ],
                    ],
                    [
                        'genre' => 'comedy',
                        'shows' => [
                            ['Mice'],
                        ],
                    ],
                    [
                        'genre' => 'drama',
                        'shows' => [
                            ['Cats'],
                            ['Dogs'],
                        ],
                    ],
                ]
            ],
            $Inventory->toArray()
        );
    }
}
