<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\Response\iResponse;
use Poirot\Std\SetterBuilderTrait;
use Poirot\Std\Interfaces\Struct\iDataStruct;
use Poirot\Std\Struct\EntityData;

class Response implements iResponse
{
    use SetterBuilderTrait;

    /** @var EntityData */
    protected $meta;
    /** @var string Origin Response Body */
    protected $rawbody;

    /** @var callable */
    protected $defaultExpected;

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
     * @return EntityData
     */
    function meta()
    {
        if (!$this->meta)
            $this->meta = new EntityData;

        return $this->meta;
    }

    /**
     * Setter Helper For Meta Data
     * @param array|iDataStruct $dataSet
     * @return $this
     */
    function setMeta($dataSet)
    {
        $this->meta()->from($dataSet);
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
     * @param callable $proc
     *
     * @return mixed
     */
    function expected(callable $proc = null)
    {
        ($proc !== null) ?: $proc = $this->defaultExpected;

        if ($proc !== null)
            return call_user_func($proc, $this->rawbody);

        return $this->rawbody;
    }
}
