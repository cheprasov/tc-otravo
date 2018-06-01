<?php

namespace TC\Otravo\Show\Entity;

class MusicalShow extends AbstractShow
{
    public function getType(): string
    {
        return ShowInterface::TYPE_MUSICAL;
    }
}
