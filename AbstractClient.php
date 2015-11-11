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
     * we keep instance of all methods called in our
     * client Object so later we can track them
     * in our client object
     *
     * ['methodName'=>MethodObjectInstance , 'anotherMethodName'=> AnotherMethodObjectInstance]
     *
     * @var iApiMethod
     */
    protected $methods;

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
        if(!$this->methods[$methodName]) {
            $method = new Method(['method' => $methodName, 'args' => $args]);
            $this->methods[] = $method;
        }
        return $this->methods[$methodName]->{$methodName}($args);

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
