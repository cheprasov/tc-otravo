<?php

namespace TC\Otravo\Show\Entity;

interface ShowInterface
{
    const TYPE_DRAMA = 'drama';
    const TYPE_COMEDY = 'comedy';
    const TYPE_MUSICAL = 'musical';

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return \DateTime
     */
    public function getDateBeg(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getDateEnd(): \DateTime;
}
