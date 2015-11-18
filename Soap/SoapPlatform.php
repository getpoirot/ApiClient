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
     * @param mixed $result Server Result
     *
     * @throws \Exception
     * @return TODO
     */
    function makeResponse($result)
    {
        return $result;
    }

    /**
     * Prepare Connection To Make Call
     *
     * - validate connection
     * - manipulate header or something in connection
     * - get connect to resource
     *
     * @param iConnection $connection
     *
     * @throws \Exception
     * @return void
     */
    function prepareConnection(iConnection $connection)
    {
        // TODO: Implement prepareConnection() method.
    }
}