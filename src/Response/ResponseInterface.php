<?php

namespace TC\Otravo\Response;

interface ResponseInterface
{
    /**
     * @param mixed $message
     */
    public function setMessage($message);

    public function echoMessage();
}
