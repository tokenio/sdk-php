<?php

namespace Tokenio;

use stdClass;
use Tokenio\Util\Base64Url;

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
        $urlDecoded = Base64Url::decode($serialized);
        $object = json_decode($urlDecoded);
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

        return Base64Url::encode(json_encode($obj));
    }
}
