<?php

namespace Tokenio\Exception;

use Io\Token\Proto\Common\Transaction\RequestStatus;

class RequestException extends \Exception
{
    private $status;

    public function __construct($status)
    {
        parent::__construct();
        $this->status = $status;
    }

    /**
     * @return RequestStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
}
