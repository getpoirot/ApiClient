<?php
namespace Poirot\ApiClient\Interfaces;

use Poirot\ApiClient\Interfaces\Request\iApiMethod;
use Poirot\ApiClient\Interfaces\Response\iResponse;

interface iClient
{
    /**
     * Get Connection Adapter
     *
     * @return iConnection
     */
    function connection();

    /**
     * Execute Request
     *
     * - prepare/validate connection with platform
     * - build expression via method/params with platform
     * - send expression as request with connection
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
    function call(iApiMethod $method);

    /**
     * Get Client Platform
     *
     * - used by request to build params for
     *   server execution call and response
     *
     * @return iPlatform
     */
    function platform();
}
