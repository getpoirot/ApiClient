<?php
namespace Poirot\ApiClient\Interfaces\Request;

/**
 * Api Method Then Build Via Platform And Turn To Expression
 * That Can Send Via Transporter Exec Method.
 *
 * @see iConnection::send
 */
interface iApiCommand
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
     * Get Method Arguments
     *
     * - we can define default arguments with some
     *   values
     *
     * @return \Iterator
     */
    function getArguments();
}
