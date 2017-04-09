<?php
namespace Poirot\ApiClient\Response;

use Poirot\ApiClient\Interfaces\Response\iResponse;


abstract class aExpectedResponse
{
    /**
     * Get Expected Result From Response Raw Body
     *
     * @param string    $originResult Raw Response Body
     * @param iResponse $self
     *
     * @return mixed
     */
    abstract function __invoke($originResult, iResponse $self);
}