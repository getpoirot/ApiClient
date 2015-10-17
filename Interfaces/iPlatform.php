<?php
namespace Poirot\ApiClient;

/**
 * In Terms Of Platforms:
 *
 * - Json RPC can be a Platform
 * - Http Context can be a Platform
 * - Web Socket Can be a Platform
 */
interface iPlatform
{
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
     * @return TODO
     */
    function makeResponse($result);
}
