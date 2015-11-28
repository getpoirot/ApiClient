<?php
namespace Poirot\ApiClient\Connection;

use Poirot\ApiClient\AbstractConnection;
use Poirot\ApiClient\Exception\ApiCallException;
use Poirot\ApiClient\Exception\ConnectException;
use Poirot\ApiClient\Interfaces\iConnection;

class ACCurl extends AbstractConnection
    implements iConnection
{
    /** @var resource */
    protected $curl;

    /** @var string Hash Latest Options */
    protected $_c__lastOptions;

    /**
     * Get Prepared Resource Connection
     *
     * - prepare resource with options
     *
     * @throws ConnectException
     * @return void
     */
    function getConnect()
    {
        if ($this->isConnected())
            $this->close();

        $rs = $this->getResourceOrigin();
        foreach ($this->options()->props()->readable as $opt)
            curl_setopt($rs, $opt, $this->options()->__get($opt));

        if (!$rs) {
            $this->close();

            throw new ConnectException('Unable to Connect ...');
        }
    }

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
    function exec($expr)
    {
        # check whether options changed or not!!
        $optsHash = md5($this->options()->toArray());
        if (!$this->_c__lastOptions)
            $this->_c__lastOptions = $optsHash;
        elseif ($this->_c__lastOptions !== $optsHash)
            ## get connect again with latest options
            $this->close();

        # get connect
        if (!$this->isConnected())
            $this->getConnect();

        $rs = $this->getResourceOrigin();

        // TODO
    }

    /**
     * Is Connection Resource Available?
     *
     * @return bool
     */
    function isConnected()
    {
        return (bool) $this->getResourceOrigin();
    }

    /**
     * Get Connection Resource Origin
     *
     * ! in case of streams connection it will return
     *   open read stream resource
     *
     * @return resource|null
     */
    function getResourceOrigin()
    {
        if ($this->curl)
            return $this->curl;

        ## get connect
        if (!extension_loaded('curl'))
            throw new ConnectException('cURL extension not installed.');

        $this->curl = curl_init();
        return $this->curl;
    }

    /**
     * Close Connection
     * @return void
     */
    function close()
    {
        if (is_resource($this->curl))
            curl_close($this->curl);

        $this->curl = null;
        $this->_c__lastOptions = null;
    }


    // ...

    /**
     * @override ide completion
     *
     * @return ACCurlOpts
     */
    function options()
    {
        return parent::options();
    }

    /**
     * @override
     *
     * @inheritdoc
     * @return ACCurlOpts
     */
    static function optionsIns()
    {
        return new ACCurlOpts;
    }
}
