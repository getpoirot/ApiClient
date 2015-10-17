<?php
namespace Poirot\ApiClient;

interface iApiRequest
{
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
     * Set Client
     *
     * @param iClient $client Client
     *
     * @return $this
     */
    function setClient(iClient $client);

    /**
     * Get Client
     *
     * @return iClient
     */
    function client();
}
