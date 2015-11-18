<?php
namespace Poirot\ApiClient\Soap;

use Poirot\ApiClient\Exception\ConnectException;
use Poirot\Core\AbstractOptions;
use Poirot\ApiClient\Exception\ApiCallException;
use Poirot\Core\Interfaces\iDataSetConveyor;

class SoapConnection extends AbstractConnection
{

    protected $options;
    protected $connection;
    protected $result;

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }




    /**
     * @param array $urls
     * @return bool
     */
    function validateUrls(array $urls)
    {
        foreach($urls as $url)
            if(filter_var($url, FILTER_VALIDATE_URL) === FALSE)
                return false;

        return true;
    }


    /**
     * Construct
     *
     * - pass connection options on construct
     *
     * @param array|iDataSetConveyor $options Connection Options
     * @throws \Exception
     */
    function __construct($options)
    {
        parent::__construct($options);

        if(empty($options['wsdl']) && (empty($options['options']['uri']) || empty($options['options']['location']) ) )
            throw new \Exception('wsdl or (options["uri"] and options["location"]) are  required as argument to create SoapConnection Instance');

        $urls = [];
        !empty($options['wsdl']) ? array_push($urls , $options['wsdl']) : array_push($urls , $options['options']['uri'],$options['options']['location']);

        if(!$this->validateUrls($urls))
            throw new \Exception('you have provided invalid urls');

        $this->getConnect();
    }

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
        $options = $this->options()->toArray();

        $wsdl = empty($options['wsdl']) ? null : $options['wsdl'];
        $args = isset($options['options']) ? $options['options'] : [];

        $sc = new \SoapClient($wsdl  ,$args );
        $this->connection = $sc;
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
        if($this->connection)
            return $this->result = $this->connection->__soapCall($expr['function_name'], $expr['arguments'], $expr['options'], $expr['input_headers'] , $expr['output_headers']);
        //return $this->result = $this->connection->{$expr['function_name']}($expr['arguments']);

        throw new ApiCallException('connection is not yet established');
    }

    /**
     * Is Connection Resource Available?
     *
     * @return bool
     */
    function isConnected()
    {
        empty($this->connection) ? false : true;
    }

    /**
     * Get Connection Resource Origin
     *
     * ! in case of streams connection it will return
     *   open read stream resource
     *
     * @return mixed
     */
    function getResourceOrigin()
    {
        // TODO: Implement getResourceOrigin() method.
    }


    function getResult()
    {
        return $this->result;
    }

    /**
     * Close Connection
     * @return void
     */
    function close()
    {
        unset($this->connection);
    }
}
