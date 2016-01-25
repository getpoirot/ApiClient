<?php
namespace Poirot\ApiClient\Soap;

use Poirot\ApiClient\Interfaces\iConnection;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiMethod;

class SoapPlatform implements iPlatform
{
    protected $result;


    function __construct()
    {

    }

    /**
     * Build Platform Specific Expression To Send
     * Trough Connection
     *
     * @param iApiMethod $method Method Interface
     *
     * @return mixed
     */
    function makeExpression(iApiMethod $method)
    {
        $expr = [
            'function_name'  => $method->getMethod(),
            'arguments'      => $method->getArguments(),
            'options'        => null,
            'input_headers'  => null,
            'output_headers' => null,
        ];

        return $expr;
    }

    /**
     * Build Response Object From Server Result
     *
     * - Result must be compatible with platform
     * - Throw exceptions if response has error
     *
     * @param mixed $response Server Result
     *
     * @throws \Exception
     * @return TODO
     */
    function makeResponse($response)
    {
        return $response;
    }

    /**
     * Prepare Connection To Make Call
     *
     * - validate connection
     * - manipulate header or something in connection
     * - get connect to resource
     *
     * @param iConnection $connection
     * @param iApiMethod|null  $method
     *
     * @throws \Exception
     * @return iConnection
     */
    function prepareConnection(iConnection $connection, $method = null)
    {
        // TODO: Implement prepareConnection() method.
    }
}