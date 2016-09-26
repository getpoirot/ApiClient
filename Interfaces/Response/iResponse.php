<?php
namespace Poirot\ApiClient\Interfaces\Response;

use Poirot\Std\Struct\DataMean;

use Psr\Http\Message\StreamInterface;

interface iResponse
{
    /**
     * Meta Data Or Headers
     *
     * @return DataMean
     */
    function meta();

    /**
     * Set Response Origin Content
     *
     * @param string|StreamInterface $content Content Body
     *
     * @return $this
     */
    function setRawResponse($content);

    /**
     * Get Response Origin Body Content
     *
     * @return string|StreamInterface
     */
    function getRawResponse();

    /**
     * Set Exception
     *
     * @param \Exception $exception Exception
     * @return $this
     */
    function setException(\Exception $exception);

    /**
     * Has Exception?
     *
     * @return \Exception|false
     */
    function hasException();

    /**
     * Process Raw Body As Expected Result
     *
     * :proc
     * mixed function($originResult);
     *
     * @param callable $callable
     *
     * @return mixed
     */
    function expected(/*callable*/ $callable = null);
}
