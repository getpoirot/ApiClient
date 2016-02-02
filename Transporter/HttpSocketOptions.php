<?php
namespace Poirot\ApiClient\Transporter;

use Poirot\Core\AbstractOptions;
use Poirot\Core\Interfaces\iDataSetConveyor;
use Poirot\Logger\Context\AbstractContext;
use Poirot\Stream\Context\Http\HttpContext;
use Poirot\Stream\Context\Http\HttpsContext;
use Poirot\Stream\Context\Socket\SocketContext;
use Poirot\Stream\StreamClientOptionsTrait;

class HttpSocketOptions extends AbstractOptions
{
    use StreamClientOptionsTrait {
        StreamClientOptionsTrait::setSocketUri as protected __hide__setSocketUri;
        StreamClientOptionsTrait::getSocketUri as protected __hide__getSocketUri;
        StreamClientOptionsTrait::setNoneBlocking as protected __hide__setNoneBlocking;
        StreamClientOptionsTrait::isNoneBlocking as protected __hide__isNoneBlocking;
    }

    protected $serverUrl;

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
