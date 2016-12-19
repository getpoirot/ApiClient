<?php
namespace Poirot\ApiClient;

use Poirot\Std\ConfigurableSetter;

use Poirot\ApiClient\Interfaces\iClient;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Interfaces\Response\iResponse;
use Poirot\ApiClient\Request\Command;


abstract class aClient
    extends ConfigurableSetter
    implements iClient
{
    ## in case of using magic get method (__get)
    ## it's better that classes that extend
    ## this Abstract Client use same platform
    ## and Transporter class property
    /** @var iPlatform */
    protected $platform;

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
     * @param iApiCommand $command Server Exec Method
     *
     * @throws \Exception
     *
     * throws Exception when $method Object is null
     *
     * @return iResponse
     */
    function call(iApiCommand $command)
    {
        $platform = $this->platform();
        $platform = $platform->withCommand($command);
        $response = $platform->send();
        
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
        $method = $this->_method();
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
        $this->_method()->__get($namespace);
        return $this;
    }


    // ..

    protected function _method()
    {
        if(!$this->method)
            $this->method = new Command;

        return $this->method;
    }
}
