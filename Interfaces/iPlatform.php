<?php
namespace Poirot\ApiClient\Interfaces;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Interfaces\Response\iResponse;


/**
 * Its Responsible To:
 *
 * - Get Commands And Interpret It To Expression Understood By Server
 * - Made Connection To Server (Lazily)
 * - Send Expression Over Wire To Server And Translate Server Response
 *   to Expected Value
 *
 */
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
