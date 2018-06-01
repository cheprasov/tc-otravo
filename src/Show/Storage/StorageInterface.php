<?php

namespace TC\Otravo\Show\Storage;

interface StorageInterface
{
    /**
     * @return \TC\Otravo\Show\Entity\ShowInterface
     */
    public function getAll(\DateTime $DateShow): array;
}
