<?php

namespace Tokenio\Tpp;

class Account extends \Tokenio\Account
{
    /**
     * @var Member
     */
    protected $member;

    /**
     * Account constructor.
     * @param $member Member
     * @param \Tokenio\Account $account
     */
    public function __construct($member, $account)
    {
        parent::__construct(null, null,$account);
        $this->member = $member;
    }

    /**
     * @return Member
     */
    public function member(){
        return $this->member;
    }
}