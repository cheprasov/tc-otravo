<?php

namespace TC\Otravo\Request;

use TC\Otravo\Exception\InvalidArgumentException;

class WebRequest implements RequestInterface
{
    use DateCheckerTrait;

    protected function getWebParams(): array
    {
        $date = $_POST['date'] ?? null;
        if (!$date || !$this->isCorrectDate($date)) {
            throw new InvalidArgumentException('Wrong show date');
        }
        return [
            'file' => 'shows.csv',
            'dateQuery' => null,
            'dateShow' => $date,
            'withPrice' => true,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFilename()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getDateQuery()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getDateShow()
    {
        $date = $_POST['date'] ?? null;
        if (!$date || !$this->isCorrectDate($date)) {
            throw new InvalidArgumentException('Wrong show date');
        }
        return $date;
    }

    /**
     * @inheritdoc
     */
    public function getWithPrice(): bool
    {
        return true;
    }
}
