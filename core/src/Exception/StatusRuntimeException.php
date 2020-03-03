<?php

namespace Tokenio\Exception;

use RuntimeException;

class StatusRuntimeException extends RuntimeException
{

    /**
     * StatusRuntimeException constructor.
     * @param $code
     * @param $description
     */
    public function __construct($code, $description)
    {
        parent::__construct($description, $code);
    }
}
