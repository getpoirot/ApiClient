<?php
namespace Poirot\ApiClient;

class Response implements iResponse
{
    /** @var string Origin Response Body */
    protected $body;

    /** @var \Exception Exception */
    protected $exception = null;


    /**
     * Get Response Body
     *
     * @return string
     */
    function attainResultFromBody()
    {
        return $this->body;
    }

    /**
     * Set Response Origin Content
     *
     * @param string $content Content Body
     *
     * @return $this
     */
    function setBody($content)
    {
        $this->body = $content;

        return $this;
    }

    /**
     * Get Response Origin Body Content
     *
     * @return string
     */
    function getBody()
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
}
