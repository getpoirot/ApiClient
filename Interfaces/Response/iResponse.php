<?php
namespace Poirot\ApiClient;

use Poirot\Core\Entity;

interface iResponse
{
    /**
     * Meta Data Or Headers
     *
     * @return Entity
     */
    function meta();

    /**
     * Set Response Origin Content
     *
     * @param string $content Content Body
     *
     * @return $this
     */
    function setRawBody($content);

    /**
     * Get Response Origin Body Content
     *
     * @return string
     */
    function getRawBody();

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
     * Process Raw Body As Result
     *
     * @return mixed
     */
    function process();
}
