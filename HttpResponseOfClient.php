<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Exceptions\exServerError;
use Poirot\ApiClient\Response\ExpectedJson;
use Poirot\Std\Struct\DataEntity;
use Psr\Http\Message\ResponseInterface;


class HttpResponseOfClient
    extends ResponseOfClient
{
    /**
     * HttpResponseOfClient constructor.
     *
     * @param ResponseInterface $httpResponse
     */
    function __construct(ResponseInterface $httpResponse)
    {
        parent::__construct(
            $httpResponse->getBody()->getContents()
            , $httpResponse->getStatusCode()
            , $httpResponse->getHeaders()
        );
    }


    /**
     * @override normalize input meta key
     * @inheritdoc
     */
    function getMeta($metaKey = null)
    {
        if (null !== $metaKey)
            $metaKey = strtolower($metaKey);


        return parent::getMeta($metaKey);
    }

    /**
     * Process Raw Body As Result
     *
     * :proc
     * mixed function($originResult, $self);
     *
     * @param callable $callable
     *
     * @return mixed
     */
    function expected(/*callable*/ $callable = null)
    {
        if ( $callable === null )
            // Retrieve Json Parsed Data Result
            $callable = $this->_getDataParser();


        return parent::expected($callable);
    }


    /**
     * Was the response successful?
     *
     * @return bool
     */
    protected function _isSuccess()
    {
        $code = $this->getResponseCode();
        return (200 <= $code && $code < 300);
    }


    /**
     * Has Exception?
     *
     * @return \Exception|false
     */
    function hasException()
    {
        if ( $this->exception )
            // Already has exception
            return $this->exception;


        ## Try to detect response include exception?
        #
        try
        {
            if (! $this->_isSuccess() ) {
                $this->doRecognizeErrorWithStatusCode( $this->getResponseCode() );

                $expected = $this->expected();
                $this->doRecognizeErrorFromExpected( $expected );
            }

        } catch (\Exception $e) {
            $this->exception = $e;
        }

        return $this->exception;
    }

    /**
     * @param $responseCode
     *
     * @throws \Exception Api Error
     */
    function doRecognizeErrorWithStatusCode($responseCode)
    {
        // Implement this in child classes
    }

    /**
     * @param DataEntity $expected
     */
    function doRecognizeErrorFromExpected($expected)
    {
        // Implement this in child classes
    }


    // ...

    function _getDataParser()
    {
        if ($this->responseCode == 204) {
            return function() {
                return null;
            };
        }

        if ( false !== strpos($this->getMeta('content-type'), 'application/json') )
            // Retrieve Json Parsed Data Result
            return new ExpectedJson;
        elseif ( false !== strpos($this->getMeta('content-type'), 'text/html') )
            return function ($raw) {
                return $raw;
            };


        throw new exServerError($this->rawBody);
    }

    /**
     * @override Override to normalize headers label/value
     * @inheritdoc
     */
    protected function _assertMetaData($meta)
    {
        $meta = parent::_assertMetaData($meta);

        foreach ($meta as $label => $value) {
            unset($meta[$label]);
            if ( is_array($value) )
                $value = implode(", ", $value);

            $meta[strtolower($label)] = $value;
        }

        return $meta;
    }
}
