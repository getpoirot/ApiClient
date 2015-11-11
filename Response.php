<?php
namespace Poirot\ApiClient;

use Poirot\Core\BuilderSetterTrait;
use Poirot\Core\Entity;

class Response implements iResponse
{
    use BuilderSetterTrait;

    /** @var Entity */
    protected $meta;

    /** @var string Origin Response Body */
    protected $body;

    /** @var \Exception Exception */
    protected $exception = null;

    /**
     * Construct
     *
     * @param array $options
     */
    function __construct(array $options = [])
    {
        if (!empty($options))
            $this->setupFromArray($options);
    }

    /**
     * Meta Data Or Headers
     *
     * @return Entity
     */
    function meta()
    {
        if (!$this->meta)
            $this->meta = new Entity;

        return $this->meta;
    }

    /**
     * Set Response Origin Content
     *
     * @param string $content Content Body
     *
     * @return $this
     */
    function setRawBody($content)
    {
        $this->body = $content;

        return $this;
    }

    /**
     * Get Response Origin Body Content
     *
     * @return string
     */
    function getRawBody()
    {
        return $this->body;
    }

    /**
     * Set Exception
     *
     * @param \Exception $exception Exception
     * @return $this
     */
    function setException(\Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Has Exception?
     *
     * @return \Exception
     */
    function hasException()
    {
        return $this->exception;
    }

    /**
     * Get Response Body
     *
     * @return string
     */
    function process()
    {
        return $this->body;
    }
}
