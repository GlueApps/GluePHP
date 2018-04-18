<?php

namespace GlueApps\GluePHP\Event;

use Symfony\Component\EventDispatcher\Event;
use GlueApps\GluePHP\Request\RequestInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class RequestEvent extends Event
{
    protected $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
