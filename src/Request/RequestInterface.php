<?php

namespace TC\Otravo\Request;

interface RequestInterface
{
    /**
     * @return string|null
     */
    public function getFilename();

    /**
     * @return string|null
     */
    public function getDateQuery();

    /**
     * @return string|null
     */
    public function getDateShow();

    /**
     * @return bool
     */
    public function getWithPrice(): bool;
}
