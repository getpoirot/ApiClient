<?php
namespace Poirot\ApiClient\Interfaces\Request;

/**
 * Api Method Then Build Via Platform And Turn To Expression
 * That Can Send Via Transporter Exec Method.
 *
 */
interface iApiCommand
    /* extends \Traversable */
{
    /**
     * Get Namespace
     *
     * @return array
     */
    function getNamespace();

    /**
     * Get Method Name
     *
     * @return string
     */
    function getMethodName();

    /**
     * Describe only command Definition as string
     *
     * ! arguments not assumed
     *
     * @return string
     */
    function __toString();
}
