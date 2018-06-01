<?php

namespace TC\Otravo\Show\Ticket;

use TC\Otravo\Show\Entity\ShowInterface;

class TicketInfo
{
    const STATUS_SALE_NOT_STARTED = 'sale not started';
    const STATUS_OPEN_FOR_SALE = 'open for sale';
    const STATUS_SOLD_OUT = 'sold out';
    const STATUS_IN_THE_PAST = 'in the past';

    /**
     * @var ShowInterface
     */
    protected $Show;

    /**
     * @var \DateTime
     */
    protected $DateQuery;

    /**
     * @var \DateTime
     */
    protected $DateShow;

    /**
     * @var string
     */
    protected $status = '';

    /**
     * @var int
     */
    protected $hallСapacity = 0;

    /**
     * @var int
     */
    protected $availableForSale = 0;

    /**
     * @var int
     */
    protected $soldCount = 0;

    /**
     * @var string|null
     */
    protected $price;


    public function __construct(ShowInterface $Show, \DateTime $DateQuery, \DateTime $DateShow)
    {
        $this->Show = $Show;
        $this->DateQuery = $DateQuery;
        $this->DateShow = $DateShow;
    }

    /**
     * @return ShowInterface
     */
    public function getShow(): ShowInterface
    {
        return $this->Show;
    }

    /**
     * @return \DateTime
     */
    public function getDateShow(): \DateTime
    {
        return $this->DateShow;
    }

    /**
     * @return \DateTime
     */
    public function getDateQuery(): \DateTime
    {
        return $this->DateQuery;
    }

    /**
     * @param \DateTime $DateQuery
     */
    public function setDateQuery(\DateTime $DateQuery)
    {
        $this->DateQuery = $DateQuery;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param int $hallСapacity
     */
    public function setHallСapacity(int $hallСapacity)
    {
        $this->hallСapacity = $hallСapacity;
    }

    /**
     * @return int
     */
    public function getHallСapacity(): int
    {
        return $this->hallСapacity;
    }

    /**
     * @param int $availableForSale
     */
    public function setAvailableForSale(int $availableForSale)
    {
        $this->availableForSale = $availableForSale;
    }

    /**
     * @return int
     */
    public function getAvailableForSale(): int
    {
        return $this->availableForSale;
    }

    /**
     * @param int $soldCount
     */
    public function setSoldCount(int $soldCount)
    {
        $this->soldCount = $soldCount;
    }

    /**
     * @return int
     */
    public function getSoldCount()
    {
        return $this->soldCount;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $arr = [
            'title' => $this->getShow()->getTitle(),
            'tickets left' => $this->hallСapacity - $this->soldCount,
            'tickets available' => $this->availableForSale,
            'status' => $this->status,
        ];
        if (!is_null($this->price)) {
            $arr['price'] = $this->price;
        }
        return $arr;
    }
}
