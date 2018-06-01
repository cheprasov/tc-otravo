<?php

namespace TC\Otravo\Response;

class WebResponse extends CliResponse implements WebResponseInterface
{
    /**
     * @var int
     */
    protected $code = WebResponseInterface::CODE_OK;

    /**
     * @var array
     */
    protected $headers = [
        'Content-Type' => WebResponseInterface::CONTENT_TYPE_JSON,
    ];

    /**
     * @inheritdoc
     */
    public function setCode(int $code)
    {
        $this->code = $code;
    }


    public function echoMessage()
    {
        http_response_code($this->code);
        foreach ($this->headers as $key => $value) {
            header("{$key}:{$value}", true);
        }
        parent::echoMessage();
    }
}
