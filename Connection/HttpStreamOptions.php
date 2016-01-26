<?php
namespace Poirot\ApiClient\Connection;

use Poirot\Core\AbstractOptions;

class HttpStreamOptions extends AbstractOptions
{
    protected $serverUrl;

    protected $timeout = 20;

    /** @var bool Http Transporter Allowed To Decode Body Response */
    protected $allowedDecoding = true;
    protected $persist;

    /**
     * Server Url That we Will Connect To
     * @param string $serverUrl
     * @return $this
     */
    public function setServerUrl($serverUrl)
    {
        $this->serverUrl = (string) $serverUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getServerUrl()
    {
        return $this->serverUrl;
    }

    /**
     * @param mixed $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (int) $timeout;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param mixed $persist
     * @return $this
     */
    public function setPersist($persist = true)
    {
        $this->persist = (bool) $persist;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersist()
    {
        return $this->persist;
    }
}
