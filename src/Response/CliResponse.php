<?php

namespace TC\Otravo\Response;

class CliResponse implements ResponseInterface
{
    /**
     * @var mixed
     */
    protected $message;

    /**
     * @inheritdoc
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function echoMessage()
    {
        echo json_encode($this->message, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
