<?php
namespace Poirot\ApiClient\Request;


trait tCommandHelper
{
    /**
     * Get Namespace
     *
     * @return array
     */
    function getNamespace()
    {
        return [];
    }

    /**
     * Get Method Name
     *
     * @ignore Ignored by getterHydrate
     * @return string
     */
    function getMethodName()
    {
        $reflect = new \ReflectionClass($this);
        return $reflect->getShortName();
    }

    /**
     * Command Representation
     *
     * @return string
     */
    function __toString()
    {
        $nameSpace = implode('\\', $this->getNamespace());
        ($nameSpace == '') ?: $nameSpace.= '::';
        $name = $nameSpace . $this->getMethodName();

        return $name;
    }
}
