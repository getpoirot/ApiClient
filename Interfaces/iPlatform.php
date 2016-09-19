<?php
namespace Poirot\ApiClient\Interfaces;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Interfaces\Response\iResponse;


interface iPlatform
{
    /**
     * Build Platform Specific Expression To Send Trough Transporter
     *
     * @param iApiCommand $command Method Interface
     *
     * @return iPlatform Self or Copy/Clone
     */
    function withCommand(iApiCommand $command);

    /**
     * Build Response with send Expression over Transporter
     *
     * - Result must be compatible with platform
     * - Throw exceptions if response has error
     *
     * @throws \Exception Command Not Set
     * @return iResponse
     */
    function send();
}
