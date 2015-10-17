<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Request\Method;
use Poirot\Rpc\Client\ClientInterface;

class Request extends Method implements
    iApiRequest
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * Construct
     *
     * @param iClient $client
     */
    public function __construct(iClient $client)
    {
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

        $client   = $this->getClient();
        $platform = $client->platform();

        $expr     = $platform->buildExpression($method);

        $result   = $client->connection()
            ->exec($expr);

        $response = $platform->buildResponse($result);

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
 