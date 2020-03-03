<?php

namespace Tokenio\User;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Token\AccessBody;
use Io\Token\Proto\Common\Token\AccessBody\Resource;
use Io\Token\Proto\Common\Token\ActingAs;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use Tokenio\Exception\IllegalArgumentException;
use Tokenio\Util\Strings;

class AccessTokenBuilder
{
    const REF_ID_MAX_LENGTH= 18;

    /* @var TokenPayload $payload */
    private $payload;

    /* @var $tokenrequestId string */
    private $tokenRequestId;

    /**
     * AccessTokenBuilder constructor.
     * @param  $payload TokenPayload
     * @param  $tokenRequestId string
     */
    public function __construct($payload= null, $tokenRequestId= null)
    {
        if($payload === null and $tokenRequestId === null)
        {
            $this->payload = new TokenPayload();
            $this->payload->setVersion("1.0")
                ->setRefId(Strings::generateNonce())
                ->setAccess(new AccessBody());
        }
        else{
            $this->payload = $payload;
            if($this->payload->getAccess() === null)
            {
                $this->payload->setAccess(new AccessBody());
            }
            $this->tokenRequestId = $tokenRequestId;
        }
    }

    public static function create($redeemerAlias, $redeemerMemberId= null)
    {
        if($redeemerMemberId !== null)
        {
            $accessToken = new AccessTokenBuilder();
            return $accessToken->to($redeemerMemberId, null);
        }
        else {
            $accessToken = new AccessTokenBuilder();
            return $accessToken->to(null, $redeemerAlias);
        }
    }

    /**
     * @param $payload TokenPayload
     * @return AccessTokenBuilder
     */
    public static function fromPayload($payload)
    {
        $newPayload = unserialize(serialize($payload));  // this will make deep copy of object
        $newAccessBody = new AccessBody();
        $newPayload->setAccess($newAccessBody)->setRefId(Strings::generateNonce());
        return new AccessTokenBuilder($newPayload, null);
    }


    public static function fromTokenRequest($tokenRequest)
    {

    }
    /**
     * @param $refId
     * @return AccessTokenBuilder
     * @throws IllegalArgumentException
     */
    public function setRefId($refId)
    {
        if(strlen($refId) > self::REF_ID_MAX_LENGTH)
        {
            throw new IllegalArgumentException(sprintf("The length of the refId is at most %s, got: %s", self::REF_ID_MAX_LENGTH, strlen($refId)));
        }
        $this->payload->setRefId($refId);
        return $this;
    }

    /**
     * @param $addressId string
     * @return AccessTokenBuilder
     */
    public function forAddress($addressId)
    {
        $address = new AccessBody\Resource\Address();
        $address->setAddressId($addressId);

        /* @var $resource Resource */
        $resource = new Resource();
        $resource->setAddress($address);

        $this->payload->getAccess()->getResources()[]= $resource;

        return $this;
    }

    /**
     * @param $accountId string
     * @return AccessTokenBuilder
     */
    public function forAccount($accountId)
    {
        $account = new AccessBody\Resource\Account();
        $account->setAccountId($accountId);

        /* @var $resource Resource */
        $resource = new Resource();
        $resource->setAccount($account);
        $this->payload->getAccess()->getResources()[] = $resource;
        return $this;
    }

    /**
     * @param $accountId string
     * @return AccessTokenBuilder
     */
    public function forAccountTransactions($accountId)
    {
        $accountTransactions = new AccessBody\Resource\AccountTransactions();
        $accountTransactions->setAccountId($accountId);

        /** @var  Resource $resource */
        $resource = new Resource();
        $resource->setTransactions($accountTransactions);

        $this->payload->getAccess()->getResources()[] = $resource;
        return $this;
    }

    /**
     * @param $accountId string
     * @return AccessTokenBuilder
     */
    public function forAccountStandingOrders($accountId)
    {
        $account = new AccessBody\Resource\AccountStandingOrders();
        $account->setAccountId($accountId);

        /** @var  Resource $resource */
        $resource = new Resource();
        $resource->setStandingOrders($account);

        $this->payload->getAccess()->getResources()[] = $resource;
        return $this;
    }

    /**
     * @param $accountId string
     * @return AccessTokenBuilder
     */
    public function forAccountBalances($accountId)
    {
        $accountBalance = new AccessBody\Resource\AccountBalance();
        $accountBalance->setAccountId($accountId);

        /** @var  Resource $resource */
        $resource = new AccessBody\Resource();
        $resource->setBalance($accountBalance);

        $this->payload->getAccess()->getResources()[] = $resource;
        return $this;
    }

    /**
     * @param $accountId string
     * @return AccessTokenBuilder
     */
    public function forTransferDestinations($accountId)
    {
        $transferDestinations = new AccessBody\Resource\TransferDestinations();
        $transferDestinations->setAccountId($accountId);

        /** @var  Resource $resource */
        $resource = new AccessBody\Resource();
        $resource->setTransferDestinations($transferDestinations);

        $this->payload->getAccess()->getResources()[] = $resource;
        return $this;
    }

    /**
     * @param $accountId string
     * @return AccessTokenBuilder
     */
    public function forFundsConfirmation($accountId)
    {
        $account = new AccessBody\Resource\FundsConfirmation();
        $account->setAccountId($accountId);

        /** @var  Resource $resource */
        $resource = new Resource();
        $resource->setFundsConfirmation($account);

        $this->payload->getAccess()->getResources()[] = $resource;
        return $this;
    }

    /**
     * Sets "from" field on the payload.
     *
     * @param $memberId string
     * @return AccessTokenBuilder
     */
    public function from($memberId)
    {
        $member = new TokenMember();
        $member->setId($memberId);

        $this->payload->setFrom($member);
        return $this;
    }

    /**
     * Sets "to" field on the payload.
     *
     * @param $redeemerMemberId string
     * @param  $redeemerAlias Alias
     * @return AccessTokenBuilder
     */
    public function to($redeemerMemberId, $redeemerAlias= null)
    {
        if($redeemerAlias !== null)
        {
            $member = new TokenMember();
            $member->setAlias($redeemerAlias);
            $this->payload->setTo($member);
        } else {
            $member = new TokenMember();
            $member->setId($redeemerMemberId);
            $this->payload->setTo($member);
        }

        return $this;
    }

    /**
     * @param $actingAs ActingAs
     * @return AccessTokenBuilder
     */
    public function actingAs($actingAs)
    {
        $this->payload->setActingAs($actingAs);
        return $this;
    }

    /**
     * @return TokenPayload
     * @throws IllegalArgumentException
     */
    public function build()
    {
        if(sizeof($this->payload->getAccess()->getResources())=== 0)
        {
            throw new IllegalArgumentException("At least one access resource must be set");
        }
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getTokenRequestId()
    {
        return $this->tokenRequestId;
    }
}