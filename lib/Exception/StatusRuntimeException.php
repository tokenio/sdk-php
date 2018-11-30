<?php

namespace Tokenio\Exception;

use Tokenio\RuntimeException;

class StatusRuntimeException extends RuntimeException
{

    public function __construct($code, $description)
    {
        parent::__construct($description, $code);
    }
}
