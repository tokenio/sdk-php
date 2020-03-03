<?php

namespace Tokenio\TokenRequest;

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


    /**
     * @param $csrfTokenHash string
     * @param $state string
     * @return TokenRequestState
     */
    public static function create($csrfTokenHash, $state)
    {
        return new TokenRequestState($csrfTokenHash, $state);
    }

    public function __construct($csrfTokenHash, $state)
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
