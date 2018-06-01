<?php

namespace TC\Otravo\Show;

use TC\Otravo\Show\Entity\ShowInterface;
use TC\Otravo\Show\Ticket\TicketInfo;

class Inventory
{
    protected $inventory = [
        ShowInterface::TYPE_MUSICAL => [],
        ShowInterface::TYPE_COMEDY => [],
        ShowInterface::TYPE_DRAMA => [],
    ];

    public function add(TicketInfo $TicketInfo)
    {
        $this->inventory[$TicketInfo->getShow()->getType()][] = $TicketInfo;
    }

    public function toArray(): array
    {
        $inventory = [];
        /**
         * @var TicketInfo[] $TicketInfos
         */
        foreach ($this->inventory as $type => $TicketInfos) {
            foreach ($TicketInfos as $TicketInfo) {
                if (!isset($inventory[$type])) {
                    $inventory[$type] = [
                        'genre' => $type,
                        'shows' => [],
                    ];
                }
                $inventory[$type]['shows'][] = $TicketInfo->toArray();
            }
        }

        return [
            'inventory' => array_values($inventory),
        ];
    }
}
