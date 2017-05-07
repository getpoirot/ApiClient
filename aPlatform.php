<?php
namespace Poirot\ApiClient;

use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Interfaces\Response\iResponse;
use Poirot\Std\ConfigurableSetter;


class aPlatform
    extends ConfigurableSetter
    implements iPlatform
{
    /** @var iApiCommand */
    protected $Command;


    /**
     * Build Platform Specific Expression To Send Trough Transporter
     *
     * @param iApiCommand $command Method Interface
     *
     * @return iPlatform Self or Copy/Clone
     */
    function withCommand(iApiCommand $command)
    {
        $self = clone $this;
        $self->Command = $command;
        return $self;
    }

    /**
     * Build Response with send Expression over Transporter
     *
     * - Result must be compatible with platform
     * - Throw exceptions if response has error
     *
     * @throws \Exception Command Not Set
     * @return iResponse
     */
    final function send()
    {
        if (! $command = $this->Command )
            throw new \Exception('No Command Is Specified.');


        // Alter Platform Commands
        $methodName = $command->getMethodName();
        $nameSpace  = implode('_', $command->getNamespace());
        $alterCall  = $nameSpace.'_'.$methodName;
        if (! method_exists($this, $alterCall) )
            throw new \BadMethodCallException(sprintf(
                'Method (%s) is not defined in Platform as (%s).'
                , $command->getMethodName()
                , $alterCall
            ));


        // Call Alternative Method Call Instead ...
        $r = $this->{$alterCall}( $command );
        if (! $r instanceof iResponse)
            throw new \Exception(sprintf(
                'Result from (%s) must be instance of iResponse. given: (%s).'
                , $alterCall, \Poirot\Std\flatten($r)
            ));

        return $r;
    }
}

