<?php
namespace Poirot\ApiClient\Interfaces\Response;

use Poirot\Core\Entity;
use Poirot\Stream\Interfaces\iStreamable;

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
     * @param string|iStreamable $content Content Body
     *
     * @return $this
     */
    function setRawBody($content);

    /**
     * Get Response Origin Body Content
     *
     * @return string|iStreamable
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
