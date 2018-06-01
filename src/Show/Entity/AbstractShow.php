<?php

namespace TC\Otravo\Show\Entity;

abstract class AbstractShow implements ShowInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var \DateTime
     */
    protected $DateBeg;

    /**
     * @var \DateTime
     */
    protected $DateEnd;

    public function __construct(string $title, \DateTime $DateBeg, \DateTime $DateEnd)
    {
        $this->title = $title;
        $this->DateBeg = $DateBeg;
        $this->DateEnd = $DateEnd;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return \DateTime
     */
    public function getDateBeg(): \DateTime
    {
        return $this->DateBeg;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): \DateTime
    {
        return $this->DateEnd;
    }
}
