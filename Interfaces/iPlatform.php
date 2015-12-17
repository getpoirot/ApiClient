<?php
namespace Poirot\ApiClient\Interfaces;

use Poirot\ApiClient\Interfaces\Request\iApiMethod;
use Poirot\ApiClient\Interfaces\Response\iResponse;

interface iPlatform
{
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
     * @return iConnection
     */
    function prepareConnection(iConnection $connection);

    /**
     * Build Platform Specific Expression To Send
     * Trough Connection
     *
     * @param iApiMethod $method Method Interface
     *
     * @return mixed
     */
    function makeExpression(iApiMethod $method);

    /**
     * Build Response Object From Server Result
     *
     * - Result must be compatible with platform
     * - Throw exceptions if response has error
     *
     * @param mixed $result Server Result
     *
     * @throws \Exception
     * @return iResponse
     */
    function makeResponse($result);
}
