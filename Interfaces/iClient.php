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
     * - get and prepare connection via platform
     * - build method and params via platform
     * - send request
     * - build response via platform
     * - return response
     *
     * @param iApiMethod $method Server Exec Method
     *
     * @return iResponse
     */
    function call(iApiMethod $method = null);

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
