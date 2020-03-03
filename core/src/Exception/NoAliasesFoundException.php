<?php

namespace Tokenio\Exception;

use const Grpc\STATUS_NOT_FOUND;

class NoAliasesFoundException extends StatusRuntimeException
{
    /**
     * NoAliasesFoundException constructor.
     * @param $memberId
     */
    public function __construct($memberId)
    {
        parent::__construct(STATUS_NOT_FOUND,`No aliases found for member : %s`.$memberId);
    }
}
