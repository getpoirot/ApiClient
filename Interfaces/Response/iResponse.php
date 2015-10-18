<?php
namespace Poirot\ApiClient;

interface iResponse
{
    /**
     * Get Response Result
     *
     * @return mixed
     */
    function attainResultFromBody();

    /**
     * Set Response Origin Content
     *
     * @param string $content Content Body
     *
     * @return $this
     */
    function setBody($content);

    /**
     * Get Response Origin Body Content
     *
     * @return string
     */
    function getBody();

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
     * @return \Exception
     */
    function hasException();
}
