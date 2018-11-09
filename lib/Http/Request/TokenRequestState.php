<?php

namespace Tokenio\Http\Request;

use stdClass;

class TokenRequestState
{
    /**
     * @var string
     */
    private $csrfTokenHash;

    /**
     * @var string
     */
    private $state;

    public function __construct($csrfTokenHash = null, $state = null)
    {
        $this->csrfTokenHash = $csrfTokenHash;
        $this->state = $state;
    }

    public static function parse($serialized)
    {
        $object = json_decode($serialized);
        return new TokenRequestState($object->csrfTokenHash, $object->state);
    }

    /**
     * @return string
     */
    public function getInnerState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCsrfTokenHash()
    {
        return $this->csrfTokenHash;
    }

    public function serialize()
    {
        $obj = new stdClass();
        $obj->csrfTokenHash = $this->csrfTokenHash;
        $obj->state = $this->state;

        return json_encode($obj);
    }
}
