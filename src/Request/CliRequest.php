<?php

namespace TC\Otravo\Request;

use TC\Otravo\Exception\InvalidArgumentException;

class CliRequest implements RequestInterface
{
    use DateCheckerTrait;

    /**
     * @inheritdoc
     */
    public function getFilename()
    {
        $filename = basename($GLOBALS['argv'][1] ?? '');
        if (!$filename) {
            throw new InvalidArgumentException('Wrong filename');
        }
        return $filename;
    }

    /**
     * @inheritdoc
     */
    public function getDateQuery()
    {
        $date = $GLOBALS['argv'][2] ?? null;
        if (!$date || !$this->isCorrectDate($date)) {
            throw new InvalidArgumentException('Wrong query date');
        }
        return $date;
    }

    /**
     * @inheritdoc
     */
    public function getDateShow()
    {
        $date = $GLOBALS['argv'][3] ?? null;
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
        return false;
    }
}
