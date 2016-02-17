<?php
namespace Poirot\ApiClient\Request;

use Poirot\ApiClient\Interfaces\Request\iApiMethod;
use Poirot\Std\SetterBuilderTrait;

/**
 * TODO define parameters name for method
 *      it can be used as notation docblock
 *      or used as setter method
 *
 *     ($country, $offset, $limit)
 */
class Method implements iApiMethod
{
    use SetterBuilderTrait;

    /** @var array Method Namespace */
    protected $namespace = [];

    /**
     * @var array Getter Namespaces Successive
     *            build from getter call
     */
    protected $namespace_getter = [];

    /**
     * @var array Cached State of Namespace During Getters Call
     */
    protected $_c__namespace = [];

    /**
     * @var string Method
     */
    protected $method;

    /**
     * @var array Method Arguments
     */
    protected $args = [];

    /**
     * Construct
     *
     * - Build Method From Setter Setup Options
     *   'namespaces'
     *   'method'
     *   'arguments'
     *
     * @param array $setupSetter
     */
    function __construct(array $setupSetter = null)
    {
       if ($setupSetter !== null)
           $this->setupFromArray($setupSetter);
    }

    /**
     * Get to next successive namespace
     *
     * @param string $namespace
     *
     * @return $this
     */
    function __get($namespace)
    {
        # append namespace
        $this->namespace_getter[] = $namespace;

        return $this;
    }

    /**
     * Call a method in this namespace.
     *
     * @param $method
     * @param $args
     *
     * @return null
     */
    function __call($method, $args)
    {
        $this->setMethod($method);

        if (!empty($args) && count($args) == 2
            && $args[0] === null
            && is_array($args[1])
            && array_values($args[1]) != $args[1] // associated array
        )
            // implement named parameters
            // {'minuend' => 42, 'subtrahend' => 23}
            // ->test(null, ['minuend'=>42, 'subtrahend' => 23]);
            // class args should be ['minuend'=>42, 'subtrahend' => 23]
            $args = $args[1];

        $this->setArguments($args);

        if ($this->namespace_getter)
            // if request build from getters set namespace and reset state
            $this->__setNamespaceFromGetters($this->namespace_getter);

        return '';
    }

    /**
     * Set Namespace From Getters
     * - save current namespace state
     * - reset getters namespace state
     * - set namespace to getters
     *
     * [php]
     * ->system->methods->Introspection(['x'=>1,])
     * [/php]
     *
     * @param array $gettersNamespaces Namespaces
     * @return $this
     */
    protected function __setNamespaceFromGetters(array $gettersNamespaces)
    {
        ($this->_c__namespace) ?: $this->_c__namespace = $this->namespace;
        $this->setNamespace($gettersNamespaces);
        $this->namespace_getter = array();

        return $this;
    }

    /**
     * Set Namespaces prefix
     *
     * - it will replace current namespaces
     * - use empty array to clear namespaces prefix
     *
     * @param array $namespaces Namespaces
     *
     * @return $this
     */
    function setNamespace(array $namespaces = [])
    {
        $this->namespace = $namespaces;

        return $this;
    }

    /**
     * Get Namespace
     *
     * @return array
     */
    function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Add Namespace
     *
     * @param string $namespace Namespace
     *
     * @return $this
     */
    function addNamespace($namespace)
    {
        $namespaces   = $this->getNamespace();
        $namespaces[] = $namespace;

        $this->namespace = $namespaces;

        return $this;
    }

    /**
     * Set Method Name
     *
     * @param string $method Method Name
     *
     * @return $this
     */
    function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get Method Name
     *
     * @return string
     */
    function getMethod()
    {
        return $this->method;
    }

    /**
     * Set Method Arguments
     *
     * - it will replace current arguments
     * - use empty array to clear arguments
     *
     * @param array $args Arguments
     *
     * @return $this
     */
    function setArguments(array $args)
    {
        $this->args = $args;

        return $this;
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
        return $this->args;
    }

    /**
     * Set Options From Array
     *
     * @param array $options Options Array
     *
     * @throws \Exception
     * @return $this
     */
    function fromArray(array $options)
    {
        $this->setupFromArray($options);
        return $this;
    }

    /**
     * Get Properties as array
     *
     * @return array
     */
    function toArray()
    {
        return [
            'namespace' => $this->getNamespace(),
            'method'    => $this->getMethod(),
            'arguments' => $this->getArguments(),
        ];
    }
}
