<?php
namespace Poirot\ApiClient\Soap;

use Poirot\ApiClient\Interfaces\iConnection;
use Poirot\ApiClient\Interfaces\iPlatform;

class SoapClient extends AbstractClient
{
    /**
     * @param iPlatform $platform
     * @param array $options
     * @throws \Exception
     */
    function __construct(iPlatform $platform, array $options=[])
    {
        if(!$platform)
            throw new \Exception('platform is not specified.');
            $this->platform = $platform;

        if($options)
            $this->options = $options[0];
    }

//    function __call($method , $args)
//    {
//        return parent::__call($method , $args);
//    }

    /**
     * Get Client Platform
     *
     * - used by request to build params for
     *   server execution call and response
     *
     * @return iPlatform
     */
    function platform()
    {
        return $pl = $this->platform ? $this->platform : new SoapPlatform();
    }

    /**
     * Get Connection Adapter
     *
     * @return iConnection
     */
    function connection()
    {

        $config = require 'config.php';

        $config = $config[$this->options['provider']];





        if(!$this->connection){
            $this->connection = new SoapConnection(['wsdl'=>$config['connect']['wsdl']]);
        }

        return $this->connection;
    }
}