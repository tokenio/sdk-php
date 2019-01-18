<?php

namespace Tokenio\Exception;

class VerificationException extends \Exception
{
    private $status;

    public function __construct($status)
    {
        parent::__construct();
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}
