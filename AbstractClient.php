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
     * @return null
     */
    function __call($methodName, $args)
    {
        if(!$this->method) {
            $method = new Method(['method' => $methodName, 'args' => $args]);
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
     * - get and prepare connection via platform
     * - build method and params via platform
     * - send request
     * - build response via platform
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
