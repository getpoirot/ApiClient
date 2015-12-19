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
interface iConnection extends iOptionsProvider
{
    /**
     * Get Prepared Resource Connection
     *
     * - prepare resource with options
     *
     * @throws ConnectException
     * @return void
     */
    function getConnect();

    /**
     * Send Expression To Server
     *
     * - send expression to server through connection
     *   resource
     * - get connect if connection not stablished yet
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
     * @throws \Exception No Connection established
     * @return null|string|Streamable
     */
    function receive();

    /**
     * Is Connection Resource Available?
     *
     * @return bool
     */
    function isConnected();

    /**
     * Close Connection
     * @return void
     */
    function close();
}
