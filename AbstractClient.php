<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\iClient;
use Poirot\ApiClient\Interfaces\iTransporter;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiMethod;
use Poirot\ApiClient\Interfaces\Response\iResponse;
use Poirot\ApiClient\Request\Method;

abstract class AbstractClient implements iClient
{
    ## in case of using magic get method
    ## it's better that classes that extend
    ## this AbstractClient use same platform
    ## and Transporter class property
    /** @var iPlatform */
    protected $platform;
    /** @var iTransporter */
    protected $Transporter;

    /**
     * we keep instance of last method called in our
     * client Object
     *
     * @var iApiMethod
     */
    protected $method;


    /**
     * Get Client Platform
     *
     * - used by request to build params for
     *   server execution call and response
     *
     * @return iPlatform
     */
    abstract function platform();

    /**
     * Execute Request
     *
     * - prepare/validate Transporter with platform
     * - build expression via method/params with platform
     * - send expression as request with Transporter
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

        $transporter = clone $this->transporter();
        $transporter = $platform->prepareTransporter($transporter, $method);

        $response = $platform->makeResponse(
            $transporter->send($platform->makeExpression($method))
        );

        return $response;
    }


    // ...

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
        $method = $this->__method();
        $method->setMethod($methodName);
        $method->setArguments($args);

        $this->method = $method;
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
        return $this->__method()->__get($namespace);
    }

    function __method()
    {
        if(!$this->method)
            $this->method = new Method;

        return $this->method;
    }
}
