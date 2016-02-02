<?php
namespace Poirot\ApiClient\Transporter;

use Poirot\Core\AbstractOptions;
use Poirot\Core\Interfaces\iDataSetConveyor;
use Poirot\Logger\Context\AbstractContext;
use Poirot\Stream\Context\Http\HttpContext;
use Poirot\Stream\Context\Http\HttpsContext;
use Poirot\Stream\Context\Socket\SocketContext;

class HttpSocketOptions extends AbstractOptions
{
    protected $serverUrl;

    protected $timeout = 20;
    protected $persist = true;
    /** @var AbstractContext */
    protected $context;

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

    /**
     * @return AbstractContext
     */
    public function getContext()
    {
        if (!$this->context) {
            $this->context = new SocketContext;
            $this->context->bindWith(new HttpContext);
            $this->context->bindWith(new HttpsContext);
        }

        return $this->context;
    }

    /**
     * @param array|iDataSetConveyor|AbstractContext $context
     * @return $this
     */
    public function setContext($context)
    {
        $this->getContext()->from($context);
        return $this;
    }
}
