<?php
namespace Poirot\ApiClient\Request;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\Std\Hydrator\HydrateGetters;


abstract class CommandIndividual
    implements iApiCommand
{
    const METHOD_NAME = 'name_of_method';


    /**
     * Get Namespace
     *
     * @ignore Ignored by getterHydrate
     * @return array
     */
    abstract function getNamespace();

    /**
     * Get Method Name
     *
     * @ignore Ignored by getterHydrate
     * @return string
     */
    function getMethodName()
    {
        return static::METHOD_NAME;
    }

    /**
     * Get Method Arguments
     *
     * - we can define default arguments with some
     *   values
     *
     * @return array
     */
    function getArguments()
    {
        $hydrate = new HydrateGetters($this, [
            // these methods are ignored ...
            'getNamespace',
            'getMethodName',
        ]);

        return $hydrate;
    }
}
