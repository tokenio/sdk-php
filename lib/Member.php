<?php

namespace Tokenio;

use Google\Protobuf\Internal\RepeatedField;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Blob\Attachment;
use Io\Token\Proto\Common\Blob\Blob\AccessMode;
use Io\Token\Proto\Common\Blob\Blob\Payload;
use Io\Token\Proto\Common\Member\MemberAliasOperation;
use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\Transaction;
use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transfer\TransferPayload;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Tokenio\Exception\InvalidRealmException;
use Tokenio\Http\Client;
use Tokenio\Http\Request\TokenRequest;
use Tokenio\Util\PagedList;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;

class Member implements RepresentableInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Creates an instance of Member.
     *
     * @param $client Client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Gets the member id.
     *
     * @return string the member id
     */
    public function getMemberId()
    {
        return $this->client->getMemberId();
    }

    /**
     * Gets the last hash
     *
     * @return string the last hash
     */
    public function getLastHash()
    {
        return $this->client->getMember($this->getMemberId())->getLastHash();
    }

    /**
     * Gets all aliases owned by the member.
     *
     * @return RepeatedField a list of aliases
     */
    public function getAliases()
    {
        return $this->client->getAliases();
    }

    /**
     * Gets the first alias owner by the user
     *
     * @return Alias the alias
     */
    public function getFirstAlias()
    {
        $aliases = $this->getAliases();
        if (empty($aliases)) {
            return null;
        }

        return $aliases[0];
    }

    /**
     * Gets all public keys for this member.
     *
     * @return RepeatedField a list of public keys
     */
    public function getKeys()
    {
        $member = $this->client->getMember($this->getMemberId());
        return $member->getKeys();
    }

    /**
     * Links a funding bank account to Token and returns it to the caller.
     *
     * @return Account[]
     */
    public function getAccounts()
    {
        $accounts = $this->client->getAccounts();

        $result = [];

        /** @var \Io\Token\Proto\Common\Account\Account $account */
        foreach ($accounts as $account) {
            $result[] = new Account($this, $account, $this->client);
        }

        return $result;
    }

    /**
     * Looks up a funding bank account linked to Token.
     *
     * @param $accountId string account id
     * @return Account
     */
    public function getAccount($accountId)
    {
        $account = $this->client->getAccount($accountId);
        return new Account($this, $account, $this->client);
    }

    /**
     * Looks up account balance.
     *
     * @param string $accountId account id
     * @param int $keyLevel key level
     * @return Balance
     * @throws Exception
     */
    public function getBalance($accountId, $keyLevel)
    {
        return $this->client->getBalance($accountId, $keyLevel);
    }

    /**
     * Looks up current account balance.
     *
     * @param string $accountId the account id
     * @param int $keyLevel key level
     * @return Money
     * @throws Exception
     */
    public function getCurrentBalance($accountId, $keyLevel)
    {
        return $this->getBalance($accountId, $keyLevel)->getCurrent();
    }

    /**
     * Looks up available account balance.
     *
     * @param string $accountId the account id
     * @param int $keyLevel key level
     * @return Money
     * @throws Exception
     */
    public function getAvailableBalance($accountId, $keyLevel)
    {
        return $this->getBalance($accountId, $keyLevel)->getAvailable();
    }

    /**
     * Looks up balances for a list of accounts.
     *
     * @param string[] $accountIds of account ids
     * @param int $keyLevel key level
     * @return Balance[]
     */
    public function getBalances($accountIds, $keyLevel)
    {
        return $this->client->getBalances($accountIds, $keyLevel);
    }

    /**
     * Looks up an existing transaction for a given account.
     *
     * @param string $accountId account id
     * @param string $transactionId ID of the transaction
     * @param int $keyLevel key level
     * @return Transaction
     * @throws Exception
     */
    public function getTransaction($accountId, $transactionId, $keyLevel)
    {
        return $this->client->getTransaction($accountId, $transactionId, $keyLevel);
    }

    /**
     * Looks up transactions for a given account.
     *
     * @param string $accountId the account id
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @param int $keyLevel key level
     * @return PagedList paged list of transaction records
     * @throws Exception
     */
    public function getTransactions($accountId, $offset, $limit, $keyLevel)
    {
        return $this->client->getTransactions($accountId, $offset, $limit, $keyLevel);
    }

    /**
     * Looks up a existing token.
     *
     * @param string $tokenId token id
     * @return Token token returned by the server
     */
    public function getToken($tokenId)
    {
        return $this->client->getToken($tokenId);
    }

    /**
     * Removes an alias for the member.
     *
     * @param Alias $alias , e.g. 'john'
     * @throws Exception
     * @return bool that indicates whether the operation finished or had an error
     */
    public function removeAlias($alias)
    {
        return $this->removeAliases([$alias]);
    }

    /**
     * Removes aliases for the member.
     *
     * @param Alias[] $aliasList , e.g. 'john'
     * @return bool that indicates whether the operation finished or had an error
     * @throws Exception
     */
    public function removeAliases($aliasList)
    {
        $operations = [];
        foreach ($aliasList as $alias) {
            $operation = new MemberAliasOperation();
            $operation->setAliasHash(Util::hashAlias($alias));
        }
        $latest = $this->client->getMember($this->getMemberId());
        $updatedMember = $this->client->updateMember($latest, $operations);
        return $updatedMember !== null;
    }

    /**
     * Adds a new alias for the member.
     *
     * @param Alias $alias , e.g. 'john'
     * @throws Exception
     * @return bool that indicates whether the operation finished or had an error
     */
    public function addAlias($alias)
    {
        return $this->addAliases([$alias]);
    }

    /**
     * Adds new aliases for the member.
     *
     * @param Alias[] $aliasList , e.g. 'john'
     * @return bool that indicates whether the operation finished or had an error
     * @throws Exception
     */
    public function addAliases($aliasList)
    {
        $operations = [];
        $metadata = [];
        $member = $this->client->getMember($this->getMemberId());
        foreach ($aliasList as $alias) {
            $partnerId = $member->getPartnerId();
            if (!Strings::isEmptyString($partnerId) && $partnerId !== 'token') {
                if (!Strings::isEmptyString($alias->getRealm()) && $alias->getRealm() !== $partnerId) {
                    throw new InvalidRealmException($alias->getRealm(), $partnerId);
                }

                $alias->setRealm($partnerId);
            }
            $operations[] = Util::createAddAliasOperation(Util::normalizeAlias($alias));
            $metadata[] = Util::createAddAliasOperationMetadata(Util::normalizeAlias($alias));
        }

        $updatedMember = $this->client->updateMember($member, $operations, $metadata);
        return $updatedMember !== null;

    }

    /**
     * Creates a Representable that acts as another member using the access token
     * that was granted by that member.
     *
     * @param string $tokenId the token id
     * @param boolean $customerInitiated whether the call is initiated by the customer
     * @return Member
     */
    public function forAccessToken($tokenId, $customerInitiated = false)
    {
        $cloned = clone $this->client;
        $cloned->useAccessToken($tokenId, $customerInitiated);
        return new Member($cloned);
    }

    /**
     * Stores a token request. This can be retrieved later by the token request id.
     *
     * @param TokenRequest $tokenRequest token request
     * @return string token request id
     */
    public function storeTokenRequest($tokenRequest)
    {
        return $this->client->storeTokenRequest($tokenRequest->getTokenPayload(), $tokenRequest->getOptions(), $tokenRequest->getUserRefId());
    }

    /**
     * Creates and uploads a blob.
     *
     * @param string $ownerId the id of the owner of the blob
     * @param string $type the MIME type of the file
     * @param string $name the name of the file
     * @param string $data the file data
     * @param int $accessMode the access mode, normal or public
     * @return Attachment
     */
    public function createBlob($ownerId, $type, $name, $data, $accessMode = AccessMode::PBDEFAULT)
    {
        $payload = new Payload();
        $payload->setOwnerId($ownerId);
        $payload->setType($type);
        $payload->setName($name);
        $payload->setData($data);
        $payload->setAccessMode($accessMode);

        $blobId = $this->client->createBlob($payload);

        $attachment = new Attachment();
        $attachment->setBlobId($blobId);
        $attachment->setName($name);
        $attachment->setType($type);

        return $attachment;
    }

    /**
     * Redeems a transfer token.
     *
     * @param Token $token the transfer token
     * @param double $amount the amount to transfer
     * @param string $currency the currency
     * @param string $description the description of the transfer
     * @param TransferEndpoint $destination the transfer instruction destination
     * @param string $refId the reference id of the transfer
     * @return Transfer
     */
    public function redeemToken($token, $amount = null, $currency = null, $description = null, $destination = null, $refId = null)
    {
        $payload = new TransferPayload();
        $payload->setTokenId($token->getId());
        $payload->setDescription($token->getPayload()->getDescription());

        if ($destination != null) {
            $payload->setDestinations(array($destination));
        }

        if ($amount != null) {
            $money = new Money();
            $money->setValue($amount);
            $payload->setAmount($money);
        }

        if ($currency != null) {
            if ($payload->getAmount() != null) {
                $payload->getAmount()->setCurrency($currency);
            } else {
                $money = new Money();
                $money->setCurrency($currency);
                $payload->setAmount($money);
            }
        }

        if ($description != null) {
            $payload->setDescription($description);
        }

        if ($refId != null) {
            $payload->setRefId($refId);
        } else {
            $payload->setRefId(Strings::generateNonce());
        }

        return $this->client->createTransfer($payload);
    }
}
