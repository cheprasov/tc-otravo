<?php

namespace TC\Otravo\Show\Entity;

class DramaShow extends AbstractShow
{
    public function getType(): string
    {
        return ShowInterface::TYPE_DRAMA;
    }
}
