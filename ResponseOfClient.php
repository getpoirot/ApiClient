<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\Response\iResponse;


class ResponseOfClient
    implements iResponse
{
    protected $meta = array();

    /** @var string Origin Response Body */
    protected $rawBody;

    /** @var \Exception Exception */
    protected $exception = null;


    /**
     * iResponse constructor.
     *
     * @param string             $rawResponseBody   Response body
     * @param array|\Traversable $meta              Meta Headers
     * @param null|\Exception    $exception         Exception
     */
    function __construct($rawResponseBody, $meta = null, \Exception $exception = null)
    {
        $this->rawBody = $rawResponseBody;

        if ($meta !== null)
            $this->meta = $this->_assertMetaData($meta);

        if ($exception !== null)
            $this->exception = $exception;
    }

    /**
     * Set Meta Data Headers
     *
     * @param array|\Traversable $data Meta Data Header
     *
     * @return $this Clone
     */
    function withMeta($data)
    {
        $meta = $this->_assertMetaData($data);

        $new = clone $this;
        $new->meta = array_merge($this->meta, $meta);
        return $new;
    }

    /**
     * Set Response Origin Content
     *
     * @param string $rawBody Content Body
     *
     * @return $this
     */
    function withRawBody($rawBody)
    {
        $new = clone $this;
        $new->rawBody = $rawBody;
        return $new;
    }

    /**
     * Set Exception
     *
     * @param \Exception $exception Exception
     * @return $this
     */
    function withException(\Exception $exception)
    {
        $new = clone $this;
        $new->exception = $exception;
        return $new;
    }


    /**
     * Process Raw Body As Result
     *
     * :proc
     * mixed function($originResult, $self);
     *
     * @param callable $callable
     *
     * @return mixed
     */
    function expected(/*callable*/ $callable = null)
    {
        if ($callable !== null)
            return call_user_func($callable, $this->rawBody, $this);

        return $this->rawBody;
    }


    /**
     * Meta Data Or Headers
     *
     * @param null|string $metaKey Specific meta key to retrieve
     *
     * @return array
     * @return null|mixed When meta key given
     */
    function getMeta($metaKey = null)
    {
        if ($metaKey !== null)
            return (isset($this->meta[$metaKey])) ? $this->meta[$metaKey] : null;

        return $this->meta;
    }

    /**
     * Get Response Origin Body Content
     *
     * @return string
     */
    function getRawBody()
    {
        return $this->rawBody;
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


    // ..

    /**
     * Assert Given Meta Data
     *
     * @param array|\Traversable $meta
     *
     * @return array
     */
    protected function _assertMetaData($meta)
    {
        if ($meta instanceof \Traversable)
            $meta = iterator_to_array($meta);

        if (!is_array($meta) && array_values($meta) === $meta)
            throw new \InvalidArgumentException(sprintf(
                'Meta Must be Array Or Traversable Associated Key/Value Pair; given: (%s).'
                , \Poirot\Std\flatten($meta)
            ));

        return $meta;
    }
}
