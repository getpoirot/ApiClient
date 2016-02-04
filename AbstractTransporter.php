<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Exception\ApiCallException;
use Poirot\ApiClient\Exception\ConnectException;
use Poirot\ApiClient\Interfaces\iTransporter;
use Poirot\Core\AbstractOptions;
use Poirot\Core\Interfaces\iDataSetConveyor;
use Poirot\Core\Interfaces\iPoirotOptions;
use Poirot\Core\OpenOptions;
use Poirot\Core\Traits\CloneTrait;
use Poirot\Stream\Streamable;

abstract class AbstractTransporter implements iTransporter
{
    use CloneTrait;

    /** @var iPoirotOptions */
    protected $options;

    /**
     * Construct
     *
     * - pass transporter options on construct
     *
     * @param array|iDataSetConveyor $options Transporter Options
     */
    function __construct($options = null)
    {
        if ($options === null)
            return;

        $this->inOptions()->from($options);
    }

    /**
     * Get Prepared Resource Transporter
     *
     * - prepare resource with options
     *
     * @throws ConnectException
     * @return mixed Transporter Resource
     */
    abstract function getConnect();

    /**
     * Send Expression To Server
     *
     * - send expression to server through transporter
     *   resource
     *
     * !! it must be connected
     *
     * @param mixed $expr Expression
     *
     * @throws ApiCallException|ConnectException
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
     * @throws \Exception No Transporter established
     * @return null|string|Streamable
     */
    abstract function receive();

    /**
     * Is Transporter Resource Available?
     *
     * @return bool
     */
    abstract function isConnected();

    /**
     * Close Transporter
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
     * @param null|mixed $builder Builder Options as Constructor
     *
     * @return AbstractOptions
     */
    static function newOptions($builder = null)
    {
        return new OpenOptions($builder);
    }
}
