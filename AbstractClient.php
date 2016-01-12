<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\iClient;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiMethod;
use Poirot\ApiClient\Interfaces\Response\iResponse;
use Poirot\ApiClient\Request\Method;

abstract class AbstractClient implements iClient
{
    /**
     * we keep instance of last method called in our
     * client Object
     *
     * @var iApiMethod
     */
    protected $method;

    /**
     * Call a method in this namespace.
     *
     * @param string $methodName
     * @param array  $args
     *
     * @return iResponse
     */
    function __call($methodName, $args)
    {
        if(!$this->method) {
            $method = new Method;
            $method->setMethod($methodName);
            $method->setArguments($args);
            $this->method = $method;
        }

        return $this->call($this->method);
    }


    /**
     * __get
     * proxy function to Method class __get
     * Get to next successive namespace
     *
     * @param string $namespace
     *
     * @return $this
     */
    function __get($namespace)
    {
        return $this->method->__get($namespace);
    }


    /**
     * Execute Request
     *
     * - prepare/validate connection with platform
     * - build expression via method/params with platform
     * - send expression as request with connection
     *    . build response with platform
     * - return response
     *
     * @param iApiMethod $method Server Exec Method
     *
     * @throws \Exception
     *
     * throws Exception when $method Object is null
     *
     * @return iResponse
     */
    function call(iApiMethod $method)
    {
        $platform = $this->platform();

        $connection = clone $this->connection();
        $connection = $platform->prepareConnection($connection);

        $response = $platform->makeResponse(
            $connection->send($platform->makeExpression($method))
        );

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
