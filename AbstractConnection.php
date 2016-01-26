<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Exception\ApiCallException;
use Poirot\ApiClient\Exception\ConnectException;
use Poirot\ApiClient\Interfaces\iConnection;
use Poirot\Core\AbstractOptions;
use Poirot\Core\Interfaces\iDataSetConveyor;
use Poirot\Core\Interfaces\iPoirotOptions;
use Poirot\Core\OpenOptions;
use Poirot\Core\Traits\CloneTrait;
use Poirot\Stream\Streamable;

abstract class AbstractConnection implements iConnection
{
    use CloneTrait;

    /** @var iPoirotOptions */
    protected $options;

    /**
     * Construct
     *
     * - pass connection options on construct
     *
     * @param Array|iDataSetConveyor $options Connection Options
     */
    function __construct($options = null)
    {
        if ($options === null)
            return;

        $this->inOptions()->from($options);
    }

    /**
     * Get Prepared Resource Connection
     *
     * - prepare resource with options
     *
     * @throws ConnectException
     * @return mixed Connection Resource
     */
    abstract function getConnect();

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
    abstract function send($expr);

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
    abstract function receive();

    /**
     * Is Connection Resource Available?
     *
     * @return bool
     */
    abstract function isConnected();

    /**
     * Close Connection
     * @return void
     */
    abstract function close();

    // ...

    /**
     * @return AbstractOptions
     */
    function inOptions()
    {
        if (!$this->options)
            $this->options = static::newOptions();

        return $this->options;
    }

    /**
     * Get An Bare Options Instance
     *
     * ! it used on easy access to options instance
     *   before constructing class
     *   [php]
     *      $opt = Filesystem::optionsIns();
     *      $opt->setSomeOption('value');
     *
     *      $class = new Filesystem($opt);
     *   [/php]
     *
     * @return AbstractOptions
     */
    static function newOptions()
    {
        return new OpenOptions;
    }
}
