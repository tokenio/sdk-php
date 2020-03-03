<?php

namespace Tokenio\Exception;

class VerificationException extends \RuntimeException
{
    private $status;

    /**
     * VerificationException constructor.
     * @param $status
     */
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
