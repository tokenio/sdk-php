<?php

namespace Tokenio\User\Exception;

use Io\Token\Proto\Common\Token\TransferTokenStatus;

class TransferTokenException extends \RuntimeException
{
    /* @var TransferTokenStatus $status */
    private $status;

    /**
     * @param $status int
     */
    public function __construct($status)
    {
        parent::__construct("Failed to create token: ${status}");
        $this->status = $status;
    }

    /**
     * @return TransferTokenStatus
     */
    public function getstatus()
    {
        return $this->status;
    }
}