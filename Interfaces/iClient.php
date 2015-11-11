<?php
namespace Poirot\ApiClient;

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
     * - get connection from client
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
