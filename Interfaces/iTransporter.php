<?php
namespace Poirot\ApiClient\Interfaces;

use Poirot\ApiClient\Exception\ApiCallException;
use Poirot\ApiClient\Exception\ConnectException;
use Poirot\Core\Interfaces\iOptionsProvider;
use Poirot\Stream\Streamable;

/**
 * - Connect To Server With Configuration From Options
 * - Make Request To Server With Specific Expression
 * - Get Response Message From Server
 */
interface iTransporter extends iOptionsProvider
{
    /**
     * Get Prepared Resource Transporter
     *
     * - prepare resource with options
     *
     * @throws ConnectException
     * @return mixed Transporter Resource
     */
    function getConnect();

    /**
     * Send Expression To Server
     *
     * - send expression to server through transporter
     *   resource
     * - get connect if transporter not stablished yet
     *
     * @param mixed $expr Expression
     *
     * @throws ApiCallException
     * @return mixed Prepared Server Response
     */
    function send($expr);

    /**
     * Receive Server Response
     *
     * - it will executed after a request call to server
     *   by send expression
     * - return null if request not sent
     *
     * @throws \Exception No Transporter established
     * @return null|string|Streamable
     */
    function receive();

    /**
     * Is Transporter Resource Available?
     *
     * @return bool
     */
    function isConnected();

    /**
     * Close Transporter
     * @return void
     */
    function close();
}
