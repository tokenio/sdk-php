<?php

namespace Tokenio\User;

use Io\Token\Proto\Common\Token\Policy;
use Io\Token\Proto\Common\Token\TokenPayload;
use PhpParser\Autoloader;

class PrepareTokenResult
{

    /* @var TokenPayload $tokenPayload */
    private $tokenPayload;

    /* @var Policy $policy */
    private $policy;


    /**
     * @param $tokenPayload TokenPayload
     * @return mixed
     */
    public function __construct($tokenPayload, $policy)
    {
        $this->policy = $policy;
        $this->tokenPayload = $tokenPayload;
    }

    /**
     * @param $tokenPayload TokenPayload
     * @param $policy
     * @return PrepareTokenResult
     */
    public static function create($tokenPayload, $policy)
    {
        return new PrepareTokenResult($tokenPayload, $policy);
    }

    /**
     * @return TokenPayload
     */
    public function getTokenPayload()
    {
        return $this->tokenPayload;
    }

    /**
     * @return Policy
     */
    public function getPolicy()
    {
        return $this->policy;
    }
}