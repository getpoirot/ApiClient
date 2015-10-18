<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Request\Method;

class Request extends Method
    implements iApiRequest
{
    /**
     * @var iClient
     */
    protected $client;

    /**
     * Construct
     *
     * @param array $setupSetter
     *
     * @param iClient $client
     */
    function __construct(iClient $client, array $setupSetter = null)
    {
        parent::__construct($setupSetter);

        $this->setClient($client);
    }

    /**
     * Call a method in this namespace.
     *
     * @param string $method
     * @param array  $args
     *
     * @return null
     */
    function __call($method, $args)
    {
        parent::__call($method, $args);

        return $this->call($this);
    }

    /**
     * Send Rpc Request
     *
     * @param iApiMethod $method Rpc Method
     *
     * @return iResponse
     */
    function call(iApiMethod $method = null)
    {
        ($method) ?: $this;

        $client   = $this->client();
        $platform = $client->platform();

        $expr     = $platform->makeExpression($method);
        $result   = $platform->connection()->exec($expr);

        $response = $platform->makeResponse($result);
        return $response;
    }

    /**
     * Set Client
     *
     * @param iClient $client Client
     *
     * @return $this
     */
    function setClient(iClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get Client
     *
     * @return iClient
     */
    function client()
    {
        return $this->client;
    }
}
