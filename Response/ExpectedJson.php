<?php
namespace Poirot\ApiClient\Response;

use Poirot\ApiClient\Interfaces\Response\iResponse;
use Poirot\Std\Struct\DataEntity;


class ExpectedJson
    extends aExpectedResponse
{
    /**
     * Get Expected Result From Response Raw Body
     *
     * @param string    $originResult Raw Response Body
     * @param iResponse $self
     *
     * @return mixed
     * @throws \Exception
     */
    function __invoke($originResult, iResponse $self = null)
    {
        if (false === $result = json_decode($originResult, true))
            throw new \Exception('Server Response Cant Parse To Json.');


        return new DataEntity($result);
    }
}
