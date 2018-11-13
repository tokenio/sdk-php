<?php

namespace Tokenio;

use Google\Protobuf\Internal\RepeatedField;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Blob\Attachment;
use Io\Token\Proto\Common\Blob\Blob;
use Io\Token\Proto\Common\Blob\Blob\AccessMode;
use Io\Token\Proto\Common\Blob\Blob\Payload;
use Io\Token\Proto\Common\Member\MemberAliasOperation;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation\Authorization;
use Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation;
use Io\Token\Proto\Common\Member\MemberRemoveKeyOperation;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Security\Key;use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
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
     * Looks up an existing token transfer.
     *
     * @param string $transferId ID of the transfer record
     * @return Transfer record
     */
    public function getTransfer($transferId)
    {
        return $this->client->getTransfer($transferId);
    }

    /**
     * Looks up a list of existing transfers.
     *
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @param string $tokenId optional token id to restrict the search
     * @return PagedList containing transfer records
     */
    public function getTransfers($limit, $offset = null, $tokenId = null)
    {
        return $this->client->getTransfers($limit, $offset, $tokenId);
    }

    /**
     * Cancels the token by signing it. The signature is persisted along
     * with the token.
     *
     * @param Token $token to cancel
     * @return TokenOperationResult result of cancel token
     */
    public function cancelToken($token)
    {
        return $this->client->cancelToken($token);
    }

    /**
     * Sign with a Token signature a token request state payload.
     *
     * @param string $tokenRequestId token request id
     * @param string $tokenId token id
     * @param string $state state
     * @return Signature
     */
    public function signTokenRequestState($tokenRequestId, $tokenId, $state)
    {
        return $this->client->signTokenRequestState($tokenRequestId, $tokenId, $state);
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

    /**
     * Approves a key owned by this member. The key is added to the list
     * of valid keys for the member.
     *
     * @param key key to add to the approved list
     * @param level key privilege level
     * @return completable that indicates whether the operation finished or had an error
     */
   /* public Completable approveKey(SecretKeyPair key, Key.Level level) {
        return approveKey(Key.newBuilder()
                .setId(key.id())
                .setAlgorithm(key.cryptoType().getKeyAlgorithm())
                .setLevel(level)
                .setPublicKey(key.publicKeyString())
                .build());
    }*/

    /**
     * Approves a public key owned by this member. The key is added to the list
     * of valid keys for the member.
     *
     * @param Key $key to add to the approved list
     * @return bool that indicates whether the operation finished or had an error
     */
    public function approveKey($key)
    {
        return $this->approveKeys([$key]);
    }

    /**
     * Approves public keys owned by this member. The keys are added to the list
     * of valid keys for the member.
     *
     * @param Key[] keys to add to the approved list
     * @return bool that indicates whether the operation finished or had an error
     */
    public function approveKeys($keys)
    {
        $operations = array();
        foreach ($keys as $key){
            $operations[] = Util::createAddKeyMemberOperation($key);
        }

        return $this->updateKeys($operations);
    }

    private function updateKeys($operations)
    {
        $latestMember = $this->client->getMember($this->getMemberId());
        $updatedMember = $this->client->updateMember($latestMember, $operations);
        return $updatedMember !== null;
    }

    /**
     * Removes a public key owned by this member.
     *
     * @param string $keyId key ID of the key to remove
     * @return bool that indicates whether the operation finished or had an error
     */
    public function removeKey($keyId)
    {
        $this->removeKeys([$keyId]);
    }

    /**
     * Removes public keys owned by this member.
     *
     * @param string[] $keyIds key IDs of the keys to remove
     * @return bool that indicates whether the operation finished or had an error
     */
    public function removeKeys($keyIds)
    {
        $operations = array();
        foreach($keyIds as $keyId){
            $operation = new MemberRemoveKeyOperation();
            $operation->setKeyId($keyId);
            $operations[] = $operation;
        }
        return $this->updateKeys($operations);
    }

    /**
     * Delete the member.
     *
     * @return bool
     */
    public function deleteMember()
    {
        $this->client->deleteMember();
    }

    /**
     * Replaces a member's public profile.
     *
     * @param Profile $profile to set
     * @return Profile which is set
     */
    public function setProfile($profile)
    {
        return $this->client->setProfile($profile);
    }

    /**
     * Gets a member's public profile.
     *
     * @param string $memberId member Id whose profile we want
     * @return Profile
     */
    public function getProfile($memberId)
    {
        return $this->client->getProfile($memberId);
    }

    /**
     * Replaces auth'd member's public profile picture.
     *
     * @param string $type MIME type of picture
     * @param string $data byte array representation image data
     * @return bool that indicates whether the operation finished or had an error
     */
    public function setProfilePicture($type, $data)
    {
        $payload = new Payload();
        $payload->setOwnerId($this->getMemberId())
                ->setType($type)
                ->setName('profile')
                ->setData($data)
                ->setAccessMode(AccessMode::PBPUBLIC);

        return $this->client->setProfilePicture($payload);
    }

    /**
     * Gets a member's public profile picture. Unlike set, you can get another member's picture.
     *
     * @param string $memberId member ID of member whose profile we want
     * @param int $size desired size category (small, medium, large, original)
     * @return Blob with picture; empty blob (no fields set) if has no picture
     */
    public function getProfilePicture($memberId, $size)
    {
        return $this->client->getProfilePicture($memberId, $size);
    }

    /**
     * Verifies a given alias.
     *
     * @param string $verificationId the verification id
     * @param string $code the code
     * @return bool if operation succeed
     */
    public function verifyAlias($verificationId, $code)
    {
        return $this->client->verifyAlias($verificationId, $code);
    }

    /**
     * Retry alias verification.
     *
     * @param Alias $alias the alias to be verified
     * @return string $verificationId
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
     */
    public function addRecoveryRule($recoveryRule)
    {
        $member = $this->client->getMember($this->getMemberId());
        $memberOperation = new MemberOperation();
        $recoveryOperation = new MemberRecoveryRulesOperation();
        $recoveryOperation->setRecoveryRule($recoveryRule);
        $memberOperation->setRecoveryRules($recoveryOperation);
        $upadtedMember = $this->client->updateMember($member, [$memberOperation]);

        return $upadtedMember !== null;
    }

    /**
     * Set Token as the recovery agent.
     */
    public function useDefaultRecoveryRule()
    {
        $this->client->useDefaultRecoveryRule();
    }

    /**
     * Gets the member id of the default recovery agent.
     *
     * @return string the member id
     */
    public function getDefaultAgent()
    {
        return $this->client->getDefaultAgent();
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
     * Removes all public keys that do not have a corresponding private key stored on
     * the current device from tke member.
     *
     * @return bool that indicates whether the operation finished or had an error
     */
    public function removeNonStoredKeys()
    {
        $storedKeys = $this->client->getCryptoEngine()->getPublicKeys();
        $member = $this->client->getMember($this->getMemberId());
        $keyIdsToRemove = array();
        foreach($member->getKeys() as $key) {
            if(!in_array($key, $storedKeys, true)){
                $keyIdsToRemove[] = $key->getId();
            }
        }
        if(!empty($keyIdsToRemove)){
            return $this->removeKeys($keyIdsToRemove);
        }
        return false;
    }
}
