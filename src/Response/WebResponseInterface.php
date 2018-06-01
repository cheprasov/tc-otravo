<?php

namespace TC\Otravo\Response;

interface WebResponseInterface extends ResponseInterface
{
    const CODE_OK = 200;

    const CONTENT_TYPE_JSON = 'application/json';

    /**
     * @param int $code
     */
    public function setCode(int $code);
}
