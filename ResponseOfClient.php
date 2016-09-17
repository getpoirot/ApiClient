<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\Response\iResponse;
use Poirot\Std\ConfigurableSetter;
use Poirot\Std\Struct\DataMean;


class ResponseOfClient
    extends ConfigurableSetter
    implements iResponse
{
    /** @var DataMean */
    protected $meta;
    /** @var string Origin Response Body */
    protected $rawbody;

    /** @var callable */
    protected $defaultExpected;

    /** @var \Exception Exception */
    protected $exception = null;


    /**
     * Meta Data Or Headers
     *
     * @return DataMean
     */
    function meta()
    {
        if (!$this->meta)
            $this->meta = new DataMean;

        return $this->meta;
    }

    /**
     * Setter Helper For Meta Data
     * @param array|\Traversable $dataSet
     * @return $this
     */
    function setMeta($dataSet)
    {
        $this->meta()->import($dataSet);
        return $this;
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
        $this->rawbody = $content;
        return $this;
    }

    /**
     * Get Response Origin Body Content
     *
     * @return string
     */
    function getRawBody()
    {
        return $this->rawbody;
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
     * Default Processor of Expected Result
     *
     * :proc
     * mixed function($originResult);
     *
     * @param callable $proc
     *
     * @return $this
     */
    function setDefaultExpected(callable $proc)
    {
        $this->defaultExpected = $proc;
        return $this;
    }

    /**
     * Process Raw Body As Result
     *
     * :proc
     * mixed function($originResult);
     *
     * @param callable $callable
     *
     * @return mixed
     */
    function expected(callable $callable = null)
    {
        ($callable !== null) ?: $callable = $this->defaultExpected;

        if ($callable !== null)
            return call_user_func($callable, $this->rawbody);

        return $this->rawbody;
    }
}
