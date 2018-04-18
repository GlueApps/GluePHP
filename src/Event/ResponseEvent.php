<?php

namespace GlueApps\GluePHP\Event;

use Symfony\Component\EventDispatcher\Event;
use GlueApps\GluePHP\Response\ResponseInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class ResponseEvent extends Event
{
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
