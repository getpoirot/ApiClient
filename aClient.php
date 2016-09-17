<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\iClient;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Interfaces\Response\iResponse;
use Poirot\ApiClient\Request\Command;

use Poirot\Connection\Exception\ConnectException;
use Poirot\Connection\Interfaces\iConnection;

abstract class aClient 
    implements iClient
{
    ## in case of using magic get method (__get)
    ## it's better that classes that extend
    ## this Abstract Client use same platform
    ## and Transporter class property
    /** @var iPlatform */
    protected $platform;
    /** @var iConnection */
    protected $transporter;

    /**
     * we keep instance of last method called in our
     * client Object
     *
     * @var iApiCommand
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
     * @param iApiCommand $method Server Exec Method
     *
     * @throws \Exception
     *
     * throws Exception when $method Object is null
     *
     * @return iResponse
     */
    function call(iApiCommand $method)
    {
        $platform = $this->platform();

        $transporter = clone $this->transporter();
        $transporter = $platform->prepareTransporter($transporter, $method);

        $expression = $platform->makeExpression($method);

        try {
            if (!$transporter->isConnected())
                $transporter->getConnect();
        } catch (\Exception $e) {
            throw new ConnectException(sprintf(
                'Error While Connecting To Transporter'
            ), $e->getCode(), $e);
        }

        $response = $platform->makeResponse(
            $transporter->send($expression)
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
            $this->method = new Command;

        return $this->method;
    }
}
