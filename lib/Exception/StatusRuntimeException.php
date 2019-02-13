<?php

namespace Tokenio\Exception;

class StatusRuntimeException extends \RuntimeException
{

    public function __construct($code, $description)
    {
        parent::__construct($description, $code);
    }
}
