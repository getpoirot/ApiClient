<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\iConnection;
use Poirot\Core\AbstractOptions;
use Poirot\Core\Interfaces\iDataSetConveyor;
use Poirot\Core\Interfaces\iPoirotOptions;
use Poirot\Core\OpenOptions;
use Poirot\Rpc\Exception\ConnectionExecException;

abstract class AbstractConnection implements iConnection
{
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

        $this->options()->from($options);
    }

    /**
     * Get Prepared Resource Connection
     *
     * - prepare resource with options
     *
     * @throws ConnectException
     * @return void
     */
    abstract function getConnect();

    /**
     * Execute Expression
     *
     * - send expression to server through connection
     *   resource
     *
     * @param mixed $expr Expression
     *
     * @throws ConnectionExecException
     * @return mixed Server Result
     */
    abstract function exec($expr);

    /**
     * Is Connection Resource Available?
     *
     * @return bool
     */
    abstract function isConnected();

    /**
     * Get Connection Resource Origin
     *
     * ! in case of streams connection it will return
     *   open read stream resource
     *
     * @return mixed
     */
    abstract function getResourceOrigin();

    /**
     * @return AbstractOptions
     */
    function options()
    {
        if (!$this->options)
            $this->options = self::optionsIns();

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
    static function optionsIns()
    {
        return new OpenOptions;
    }
}
