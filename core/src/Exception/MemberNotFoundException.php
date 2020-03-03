<?php

namespace Tokenio\Exception;

use Io\Token\Proto\Common\Alias\Alias;
use RuntimeException;
use Tokenio\Util\Util;
use const Grpc\STATUS_NOT_FOUND;

class MemberNotFoundException extends RuntimeException
{
    /**
     * MemberNotFoundException constructor.
     *
     * @param Alias $alias
     */
    public function __construct($alias)
    {
        parent::__construct(STATUS_NOT_FOUND, `Member could not be resolved for alias ` . Util::toJson($alias));
    }
}
