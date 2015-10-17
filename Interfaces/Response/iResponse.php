<?php
namespace Poirot\ApiClient;

interface iResponse
{
    /**
     * Get Response Result
     *
     * @return mixed
     */
    function getResult();

    /**
     * Set Result
     *
     * @param mixed $result Result
     *
     * @return $this
     */
    function setResult($result);

    /**
     * Set Response Origin Content
     *
     * @param string $content Content Body
     *
     * @return $this
     */
    function setOrigin($content);

    /**
     * Get Response Origin Body Content
     *
     * @return string
     */
    function getOrigin();

    /**
     * Set Exception
     *
     * @param \Exception $exception Exception
     * @return $this
     */
    function setException(\Exception $exception);

    /**
     * Get Exception
     *
     * @return \Exception | null
     */
    function getException();
}
