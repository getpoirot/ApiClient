<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Request\Method;

abstract class AbstractClient extends Method
    implements iClient
{
    /**
     * Call a method in this namespace.
     *
     * @param string $method
     * @param array  $args
     *
     * @return null
     */
    function __call($method, $args)
    {
        parent::__call($method, $args);

        return $this->call($this);
    }

    /**
     * Send Rpc Request
     *
     * @param iApiMethod $method Rpc Method
     *
     * @return iResponse
     */
    function call(iApiMethod $method = null)
    {
        ($method) ?: $this;

        $platform = $this->platform();

        $expr     = $platform->makeExpression($method);
        $result   = $this->connection()->exec($expr);

        $response = $platform->makeResponse($result);
        return $response;
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
