<?php
namespace Poirot\ApiClient\Interfaces\Token;


interface iTokenProvider
{
    /**
     * Get Current Token if Not Exchange New one
     *
     * @return iAccessTokenObject
     */
    function getToken();

    /**
     * Exchange New Token
     *
     * @return iAccessTokenObject
     */
    function exchangeToken();
}
