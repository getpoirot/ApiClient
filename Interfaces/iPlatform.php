<?php
namespace Poirot\ApiClient\Interfaces;

use Poirot\ApiClient\Interfaces\Request\iApiMethod;
use Poirot\ApiClient\Interfaces\Response\iResponse;

interface iPlatform
{
    /**
     * Prepare Transporter To Make Call
     *
     * - validate transporter
     * - manipulate header or something in transporter
     * - get connect to resource
     *
     * @param iTransporter      $transporter
     * @param iApiMethod|null  $method
     *
     * @throws \Exception
     * @return iTransporter
     */
    function prepareTransporter(iTransporter $transporter, $method = null);

    /**
     * Build Platform Specific Expression To Send
     * Trough Transporter
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
     * @param mixed $response Server Result
     *
     * @throws \Exception
     * @return iResponse
     */
    function makeResponse($response);
}
