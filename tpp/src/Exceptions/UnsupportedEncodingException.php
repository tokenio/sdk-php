<?php

namespace Tokenio\Tpp\Exception;

class UnsupportedEncodingException extends \Exception
{
    /**
     * Constructs an UnsupportedEncodingException with a detail message.
     * @param string $message error message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
