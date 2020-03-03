<?php

namespace Tokenio\User;

use Google\Protobuf\Internal\Message;
use Io\Token\Proto\Common\Money\Money;
use Tokenio\User\Rpc\Client;

class Account extends \Tokenio\Account
{
    /**
     * @var Member
     */
    protected $member;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Creates the Account instance.
     *
     * @param Member $member the account owner
     * @param Client $client the RPC client used to perform operations against the server
     * @param \Tokenio\Account $account the account information
     * @param \Io\Token\Proto\Common\Account\Account $accountProtos
     */
    public function __construct($member, $client, $account = null, $accountProtos = null)
    {
        if($accountProtos != null){
            parent::__construct($member, $client, null, $accountProtos);
            $this->member = $member;
            $this->client = $client;
        } else{
            parent::__construct($member, $client, $account);
            $this->member = $member;
            $this->client = $client;
        }
    }

    /**
     * @return \Tokenio\Member|Member
     */
    public function member()
    {
        return $this->member;
    }

    /**
     * Sets this account as a member's default account.
     * @return Message
     * @throws \Exception
     */
    public function setAsDefault()
    {
        return $this->client->setDefaultAccount($this->id());
    }

    /**
     * Looks up if this account is default.
     *
     * @return bool
     * @throws \Exception
     */
    public function isDefault()
    {
        return $this->client->isDefault($this->id());
    }

    /**
     * Looks up an account current balance.
     * @param $keyLevel
     * @return Money
     * @throws \Exception
     */
    public function getCurrentBalance($keyLevel)
    {
        $balance = $this->client->getBalance($this->account->getId(), $keyLevel);
        return $balance->getCurrent();
    }

    /**
     * Looks up an account available balance.
     * @param $keyLevel
     * @return Money
     * @throws \Exception
     */
    public function getAvailableBalance($keyLevel)
    {
        $balance = $this->client->getBalance($this->account->getId(), $keyLevel);
        return $balance->getAvailable();
    }
}