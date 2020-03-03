<?php

namespace Tokenio;

use Exception;
use Google\Protobuf\Internal\RepeatedField;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Bank\BankInfo;
use Io\Token\Proto\Common\Blob\Blob;
use Io\Token\Proto\Common\Member\MemberAliasOperation;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation\Authorization;
use Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation;
use Io\Token\Proto\Common\Member\MemberRemoveKeyOperation;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\SecurityMetadata;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\StandingOrder;
use Io\Token\Proto\Common\Transaction\Transaction;
use Tokenio\Exception\InvalidRealmException;
use Tokenio\Exception\NoAliasesFoundException;
use Tokenio\Exception\RequestException;
use Tokenio\Exception\StepUpRequiredException;
use Tokenio\Rpc\Client;
use Tokenio\Security\KeyPair;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;


class Member
{
    /**
     * @var string
     */
    protected $realmId;
    /**
     * @var string
     */
    protected $memberId;
    /**
     * @var TokenCluster
     */
    protected $cluster;
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var string
     */
    protected $partnerId;

    /**
     * Creates an instance of Member.
     *
     * @param string $memberId
     * @param string $partnerId
     * @param string $realmId
     * @param Client $client
     * @param TokenCluster $cluster
     */
    public function __construct($memberId, $partnerId, $realmId, $client, $cluster)
    {
        $this->memberId = $memberId;
        $this->partnerId = $partnerId;
        $this->realmId = $realmId;
        $this->client = $client;
        $this->cluster = $cluster;
    }

    /**
     * Gets the member id.
     *
     * @return string the member id
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Gets the partner Id
     *
     * @return string|null partnerId
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * Gets realm ID of realm owner.
     *
     * @return string|null $realm owner member ID
     */
    public function getRealmId()
    {
        return $this->realmId;
    }

    /**
     * Gets the last hash
     *
     * @return string the last hash
     * @throws Exception
     */
    public function lastHash()
    {
        return $this->client->getMember()->getLastHash();
    }

    /**
     * Gets the first alias owner by the user
     *
     * @return Alias the alias
     * @throws NoAliasesFoundException
     * @throws Exception
     */
    public function firstAlias()
    {
        /** @var Alias[] $aliases */
        $aliases = $this->client->getAliases();
        if (empty($aliases)) {
            throw new NoAliasesFoundException($this->getMemberId());
        }

        return $aliases[0];
    }

    /**
     * Gets all aliases owned by the member.
     *
     * @return RepeatedField a list of aliases
     * @throws Exception
     */
    public function aliases()
    {
        return $this->client->getAliases();
    }


    /**
     * Gets all public keys for this member.
     *
     * @return RepeatedField a list of public keys
     * @throws Exception
     */
    public function getKeys()
    {
        $member = $this->client->getMember();
        return $member->getKeys();
    }

    /**
     * Links a funding bank account to Token and returns it to the caller.
     *
     * @return Account[]
     * @throws Exception
     */
    protected function getAccountsImpl()
    {
        $accounts = $this->client->getAccounts();
        $result = [];

        /* @var \Io\Token\Proto\Common\Account\Account $account */
        foreach ($accounts as $account) {
            $result[] = new Account($this, $this->client, null, $account);
        }

        return $result;
    }

    /**
     * Looks up a funding bank account linked to Token.
     *
     * @param $accountId string account id
     * @return Account
     * @throws Exception
     */
    public function getAccountImpl($accountId)
    {
        $account = $this->client->getAccount($accountId);
        return new Account($this, $this->client, null, $account);
    }

    /**
     * Adds a new alias for the member.
     *
     * @param Alias $alias , e.g. 'john'
     * @return bool that indicates whether the operation finished or had an error
     * @throws InvalidRealmException
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
     * @throws InvalidRealmException
     * @throws Exception
     */
    public function addAliases($aliasList)
    {
        $operations = [];
        $metadata = [];
        $member = $this->client->getMember($this->getMemberId());
        foreach ($aliasList as $alias) {
            if (!Strings::isEmptyString($this->partnerId) && $this->partnerId !== 'token') {
                if (!Strings::isEmptyString($alias->getRealm()) && $alias->getRealm() !== $this->partnerId) {
                    throw new InvalidRealmException($alias->getRealm(), $this->partnerId);
                }
                $alias->setRealm($this->partnerId);
            }
            if ((!empty($this->realmId)) && ($this->realmId !== null)) {
                $alias->setRealmId($this->realmId);
            }

            $operations[] = Util::toAddAliasOperation($alias);
            $metadata[] = Util::toAddAliasOperationMetadata($alias);
        }

        $latest = $this->client->getMember($this->getMemberId());
        $updatedMember = $this->client->updateMember($latest, $operations, $metadata);
        return $updatedMember !== null;
    }

    /**
     * Retry alias verification.
     *
     * @param Alias $alias the alias to be verified
     * @return string $verificationId
     * @throws Exception
     */
    public function retryVerification($alias)
    {
        return $this->client->retryVerification($alias);
    }


    /**
     * Adds the recovery rule.
     *
     * @param RecoveryRule $recoveryRule the recovery rule
     * @return bool if operation succeed
     * @throws Exception
     */
    public function addRecoveryRule($recoveryRule)
    {
        $member = $this->client->getMember($this->getMemberId());
        $memberOperation = new MemberOperation();
        $recoveryOperation = new MemberRecoveryRulesOperation();
        $recoveryOperation->setRecoveryRule($recoveryRule);
        $memberOperation->setRecoveryRules($recoveryOperation);
        $updatedMember = $this->client->updateMember($member, [$memberOperation]);

        return $updatedMember !== null;
    }

    /**
     * Set Token as the recovery agent.
     * @throws Exception
     */
    public function useDefaultRecoveryRule()
    {
        $this->client->useDefaultRecoveryRule();
    }


    /**
     * Authorizes recovery as a trusted agent.
     *
     * @param Authorization $authorization the authorization
     * @return Signature
     */
    public function authorizeRecovery($authorization)
    {
        return $this->client->authorizeRecovery($authorization);
    }

    /**
     * Gets the member id of the default recovery agent.
     *
     * @return string the member id
     * @throws Exception
     */
    public function getDefaultAgent()
    {
        return $this->client->getDefaultAgent();
    }

    /**
     * Verifies a given alias.
     *
     * @param string $verificationId the verification id
     * @param string $code the code
     * @return bool if operation succeed
     * @throws Exception
     */
    public function verifyAlias($verificationId, $code)
    {
        return $this->client->verifyAlias($verificationId, $code);
    }

    /**
     * Removes an alias for the member.
     *
     * @param Alias $alias , e.g. 'john'
     * @return bool that indicates whether the operation finished or had an error
     * @throws Exception
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
            $aliasOperation = new MemberAliasOperation();
            $aliasOperation->setAliasHash(Util::normalizeAndHashAlias($alias))
                ->setRealmId($alias->getRealmId());
            $operation = new MemberOperation();
            $operation->setRemoveAlias($aliasOperation);

            $operations[] = $operation;
        }
        $latest = $this->client->getMember($this->getMemberId());
        $updatedMember = $this->client->updateMember($latest, $operations);
        return $updatedMember !== null;
    }

    /**
     * Approves a public key owned by this member. The key is added to the list
     * of valid keys for the member.
     *
     * @param  $key
     * @param int $level
     * @return bool that indicates whether the operation finished or had an error
     * @throws Exception
     */

    public function approveKey($key, $level = null)
    {
        if($key instanceof KeyPair)
        {
            $key = $key->toKey();
        }
        if ($level != null) {
            $key->setLevel($level);
        }
        return $this->approveKeys([$key]);
    }


    /**
     * Approves public keys owned by this member. The keys are added to the list
     * of valid keys for the member.
     *
     * @param Key[] keys to add to the approved list
     * @return bool that indicates whether the operation finished or had an error
     * @throws Exception
     */
    public function approveKeys($keys)
    {
        $operations = array();
        foreach ($keys as $key) {
            $operations[] = Util::toAddKeyOperation($key);
        }
        return $this->updateKeys($operations);
    }

    /**
     * @param $operations
     * @return bool
     * @throws Exception
     */
    private function updateKeys($operations)
    {
        $latestMember = $this->client->getMember($this->memberId);
        $updatedMember = $this->client->updateMember($latestMember, $operations);
        return $updatedMember !== null;
    }

    /**
     * Removes a public key owned by this member.
     *
     * @param string $keyId key ID of the key to remove
     * @return bool that indicates whether the operation finished or had an error
     * @throws Exception
     */
    public function removeKey($keyId)
    {
        return $this->removeKeys([$keyId]);
    }

    /**
     * Removes public keys owned by this member.
     *
     * @param string[] $keyIds key IDs of the keys to remove
     * @return bool that indicates whether the operation finished or had an error
     * @throws Exception
     */
    public function removeKeys($keyIds)
    {
        $operations = array();
        foreach ($keyIds as $keyId) {
            $removeKeyOperation = new MemberRemoveKeyOperation();
            $removeKeyOperation->setKeyId($keyId);
            $operation = new MemberOperation();
            $operation->setRemoveKey($removeKeyOperation);
            $operations[] = $operation;
        }
        return $this->updateKeys($operations);
    }

    /**
     * Gets a member's public profile.
     *
     * @param string $memberId member Id whose profile we want
     * @return Profile
     * @throws Exception
     */
    public function getProfile($memberId)
    {
        return $this->client->getProfile($memberId);
    }

    /**
     * Gets a member's public profile picture. Unlike set, you can get another member's picture.
     *
     * @param string $memberId member ID of member whose profile we want
     * @param int $size desired size category (small, medium, large, original)
     * @return Blob with picture; empty blob (no fields set) if has no picture
     * @throws Exception
     */
    public function getProfilePicture($memberId, $size)
    {
        return $this->client->getProfilePicture($memberId, $size);
    }

    /**
     * Signs a token payload.
     *
     * @param TokenPayload $payload
     * @param int $keyLevel
     * @return Signature
     */
    public function signTokenPayload($payload, $keyLevel)
    {
        return $this->client->signTokenPayload($payload, $keyLevel);
    }

    /**
     * Looks up an existing transaction for a given account.
     *
     * @param string $accountId account id
     * @param string $transactionId ID of the transaction
     * @param int $keyLevel key level
     * @return Transaction
     * @throws RequestException
     * @throws StepUpRequiredException
     * @throws Exception
     */
    public function getTransaction($accountId, $transactionId, $keyLevel)
    {
        return $this->client->getTransaction($accountId, $transactionId, $keyLevel);
    }

    /**
     * Looks up transactions for a given account.
     *
     * @param string $accountId account id
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @param int $keyLevel key level
     * @param string $startDate inclusive lower bound of transaction booking date
     * @param string $endDate inclusive upper bound of transaction booking date
     * @return PagedList paged list of transaction records
     * @throws RequestException
     * @throws StepUpRequiredException
     * @throws Exception
     */
    public function getTransactions($accountId, $offset, $limit, $keyLevel, $startDate = null, $endDate = null)
    {
        return $this->client->getTransactions($accountId, $offset, $limit, $keyLevel, $startDate, $endDate);
    }

    /**
     * Look up an existing standing order and return the response.
     *
     * @param string $accountId the account id
     * @param string $standingOrderId the standing order id
     * @param int $keyLevel the key level
     * @return StandingOrder
     * @throws RequestException
     * @throws StepUpRequiredException
     * @throws Exception
     */
    public function getStandingOrder($accountId, $standingOrderId, $keyLevel)
    {
        return $this->client->getStandingOrder($accountId, $standingOrderId, $keyLevel);
    }

    /**
     * Look up standing orders and return response.
     *
     * @param string $accountId the account id
     * @param string $offset the offset
     * @param int $limit the limit
     * @param int $keyLevel the key level
     * @return PagedList list of standing orders
     * @throws RequestException
     * @throws StepUpRequiredException
     * @throws Exception
     */
    public function getStandingOrders($accountId, $offset, $limit, $keyLevel)
    {
        return $this->client->getStandingOrders($accountId, $offset, $limit, $keyLevel);
    }

    /**
     * Looks up account balance.
     *
     * @param string $accountId account id
     * @param int $keyLevel key level
     * @return Balance
     * @throws RequestException
     * @throws StepUpRequiredException
     * @throws Exception
     */
    public function getBalance($accountId, $keyLevel)
    {
        return $this->client->getBalance($accountId, $keyLevel);
    }

    /**
     * Looks up balances for a list of accounts.
     *
     * @param string[] $accountIds of account ids
     * @param int $keyLevel key level
     * @return Balance[]
     * @throws RequestException
     * @throws StepUpRequiredException
     * @throws Exception
     */
    public function getBalances($accountIds, $keyLevel)
    {
        return $this->client->getBalances($accountIds, $keyLevel);
    }

    /**
     * Confirm that the given account has sufficient funds to cover the charge.
     *
     * @param string accountId account ID
     * @param double amount charge amount
     * @param string currency charge currency
     * @return true if the account has sufficient funds to cover the charge
     * @throws Exception
     */
    public function confirmFunds($accountId, $amount, $currency)
    {
        $money = new Money();
        $money->setCurrency($currency);
        $money->setValue(strval($amount));
        return $this->client->confirmFunds($accountId, $money);
    }

    /**
     * Returns linking information for the specified bank id.
     *
     * @param string $bankId the bank id
     * @return BankInfo linking information
     * @throws Exception
     */
    public function getBankInfo($bankId)
    {
        return $this->client->getBankInfo($bankId);
    }

    /**
     * Delete the member.
     *
     * @return bool
     * @throws Exception
     */
    public function deleteMember()
    {
        return $this->client->deleteMember();
    }

    /**
     * Resolves transfer destinations for the given account id.
     *
     * @param string $accountId
     * @return RepeatedField transfer endpoints
     * @throws Exception
     */
    public function resolveTransferDestinations($accountId)
    {
        return $this->client->resolveTransferDestinations($accountId);
    }

    /**
     * Get the Token cluster, e.g. sandbox, production.
     *
     * @return TokenCluster
     */
    public function getTokenCluster() {
        return $this->cluster;
    }

    /**
     *  Creates a test bank account in a fake bank and links the account.
     *
     * @param double $balance account balance to set
     * @param string $currency currency code, e.g. "EUR"
     * @return Account the linked account
     * @throws Exception
     */
    protected function createTestBankAccountImpl($balance, $currency)
    {
        $money = new Money();
        $money->setCurrency($currency);
        $money->setValue(strval($balance));
        return $this->toAccount($this->client->createAndLinkTestBankAccount($money));
    }

    /**
     * @param $accountProto
     * @return Account
     */
    private function toAccount($accountProto)
    {
        return (new Account($this, $this->client, null, $accountProto));
    }
}