<?php

namespace Tokenio\Exception;

class StepUpRequiredException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
