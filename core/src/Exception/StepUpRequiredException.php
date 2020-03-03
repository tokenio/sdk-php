<?php

namespace Tokenio\Exception;

class StepUpRequiredException extends \RuntimeException
{
    /**
     * StepUpRequiredException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
