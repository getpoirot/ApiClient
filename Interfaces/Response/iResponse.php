<?php
namespace Poirot\ApiClient\Interfaces\Response;


/**
 * Immutable Response Api
 *
 */
interface iResponse
{
    /**
     * iResponse constructor.
     *
     * @param string             $rawResponseBody   Response body
     * @param int                $responseCode      Response code
     * @param array|\Traversable $meta              Meta Headers
     * @param null|\Exception    $exception         Exception
     */
    function __construct($rawResponseBody, $responseCode = null, $meta = null, \Exception $exception = null);


    /**
     * Set Meta Data Headers
     *
     * @param array|\Traversable $data Meta Data Header
     *
     * @return $this Clone
     */
    function withMeta($data);

    /**
     * Set Response Origin Content
     *
     * @param string $rawBody Content Raw Body
     *
     * @return $this Clone
     */
    function withRawBody($rawBody);

    /**
     * Set Response Code
     *
     * @param string $code Response code
     *
     * @return $this
     */
    function withResponseCode($code);

    /**
     * Set Exception
     *
     * @param \Exception $exception Exception
     * @return $this Clone
     */
    function withException(\Exception $exception);


    /**
     * Process Raw Body As Expected Result
     *
     * :proc
     * mixed function($originResult, $self);
     *
     * @param callable $callable
     *
     * @return mixed
     * @throws \Exception If Has Exception
     */
    function expected(/*callable*/ $callable = null);


    /**
     * Meta Data Or Headers
     *
     * @param null|string $metaKey Specific meta key to retrieve
     *
     * @return array
     * @return null|mixed When meta key given
     */
    function getMeta($metaKey = null);

    /**
     * Has Exception?
     *
     * @return \Exception|false
     */
    function hasException();

    /**
     * Get Response Origin Body Content
     *
     * @return string
     */
    function getRawBody();

    /**
     * Response Code
     *
     * @return int|null
     */
    function getResponseCode();
}
