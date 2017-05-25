<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\Token\iAccessTokenObject;
use Poirot\ApiClient\Interfaces\Token\iTokenProvider;


class TokenProviderSolid
    implements iTokenProvider
{
    /** @var iAccessTokenObject */
    protected $token;


    /**
     * TokenProviderSolid constructor.
     *
     * @param iAccessTokenObject $token
     */
    function __construct(iAccessTokenObject $token)
    {
        $this->token = $token;
    }


    /**
     * Get Current Token if Not Exchange New one
     *
     * @return iAccessTokenObject
     */
    function getToken()
    {
        return $this->token;
    }

    /**
     * Exchange New Token
     *
     * @return iAccessTokenObject
     * @throws \Exception
     */
    function exchangeToken()
    {
        throw new \Exception('Exchange Method for SolidToken Not Implemented.');
    }
}
