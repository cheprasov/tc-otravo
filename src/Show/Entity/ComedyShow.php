<?php

namespace TC\Otravo\Show\Entity;

class ComedyShow extends AbstractShow
{
    public function getType(): string
    {
        return ShowInterface::TYPE_COMEDY;
    }
}
