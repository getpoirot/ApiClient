<?php
namespace Poirot\ApiClient\Interfaces;

use Poirot\ApiClient\Exception\ApiCallException;
use Poirot\ApiClient\Exception\ConnectException;
use Poirot\Core\Interfaces\OptionsProviderInterface;

/**
 * - Connect To Server With Configuration From Options
 * - Make Request To Server With Specific Expression
 * - Get Response Message From Server
 */
interface iConnection extends OptionsProviderInterface
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
     * Execute Expression
     *
     * - send expression to server through connection
     *   resource
     *
     * @param mixed $expr Expression
     *
     * @throws ApiCallException
     * @return mixed Server Result
     */
    function exec($expr);

    /**
     * Is Connection Resource Available?
     *
     * @return bool
     */
    function isConnected();

    /**
     * Get Connection Resource Origin
     *
     * ! in case of streams connection it will return
     *   open read stream resource
     *
     * @return mixed
     */
    function getResourceOrigin();

    /**
     * Close Connection
     * @return void
     */
    function close();
}
