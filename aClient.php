<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Interfaces\Response\iResponse;


abstract class aClient
{
    /**
     * Get Client Platform
     *
     * - used by request to build params for
     *   server execution call and response
     *
     * @return iPlatform
     */
    abstract protected function platform();
    
    /**
     * Execute Request
     *
     * - prepare/validate Transporter with platform
     * - build expression via method/params with platform
     * - send expression as request with Transporter
     *    . build response with platform
     * - return response
     *
     * @param iApiCommand $command Server Exec Method
     *
     * @throws \Exception
     *
     * throws Exception when $method Object is null
     *
     * @return iResponse
     */
    protected function call(iApiCommand $command)
    {
        $platform = $this->platform();
        $platform = $platform->withCommand($command);
        $response = $platform->send();

        // add some extra information represent state into response object
        if ( method_exists($platform, 'getServerUrl') )
            $response = $response->withMeta(['_url_' => $platform->getServerUrl()]);


        return $response;
    }
}
