<?php
namespace Poirot\ApiClient\Exceptions;

/*
if ($cResponseCode != 200)
    $exception =  new exHttpResponse("Request have errors", $cResponseCode);
*/

class exHttpResponse
    extends \RuntimeException
{

}
