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
     * Get Request Object Interface
     *
     * - inject client to request object
     *   ! to get platform to build response/expression
     *   ! to get connection to exec expression
     *
     * @return iApiRequest
     */
    function request();

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
