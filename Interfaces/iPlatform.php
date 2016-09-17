<?php
namespace Poirot\ApiClient\Interfaces;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Interfaces\Response\iResponse;

use Poirot\Connection\Interfaces\iConnection;

interface iPlatform
{
    /**
     * Prepare Transporter To Make Call
     *
     * - validate transporter
     * - manipulate header or something in transporter
     * - get connect to resource
     *
     * @param iConnection      $transporter
     * @param iApiCommand|null  $command
     *
     * @throws \Exception
     * @return iConnection
     */
    function prepareTransporter(iConnection $transporter, $command = null);

    /**
     * Build Platform Specific Expression To Send
     * Trough Transporter
     *
     * @param iApiCommand $method Method Interface
     *
     * @return mixed
     */
    function makeExpression(iApiCommand $method);

    /**
     * Build Response Object From Server Result
     *
     * - Result must be compatible with platform
     * - Throw exceptions if response has error
     *
     * @param mixed $response Server Result
     *
     * @throws \Exception
     * @return iResponse
     */
    function makeResponse($response);
}
