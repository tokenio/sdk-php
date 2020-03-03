<?php

namespace Tokenio\Exception;

use Exception;

class InvalidRealmException extends Exception
{
    public function __construct($actualRealm, $expectedRealm)
    {
        parent::__construct(sprintf('Invalid realm %s; expected: %s', $actualRealm, $expectedRealm));
    }
}
