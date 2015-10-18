<?php
namespace Poirot\ApiClient;

abstract class AbstractClient implements iClient
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Get Request Object Interface
     *
     * - inject client to request object
     *   ! to get platform to build response/expression
     *   ! to get connection to exec expression
     *
     * @return iApiRequest
     */
    function request()
    {
        if (!$this->request)
            $this->request = new Request($this);

        $this->request->setClient($this);

        return $this->request;
    }

    /**
     * Get Client Platform
     *
     * - used by request to build params for
     *   server execution call and response
     *
     * @return iPlatform
     */
    abstract function platform();
}
