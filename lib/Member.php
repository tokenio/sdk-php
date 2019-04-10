<?php

namespace Tokenio;

use Google\Protobuf\Internal\RepeatedField;
use Io\Token\Proto\Common\Address\Address;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Bank\BankInfo;
use Io\Token\Proto\Common\Blob\Attachment;
use Io\Token\Proto\Common\Blob\Blob;
use Io\Token\Proto\Common\Blob\Blob\AccessMode;
use Io\Token\Proto\Common\Blob\Blob\Payload;
use Io\Token\Proto\Common\Member\AddressRecord;
use Io\Token\Proto\Common\Member\MemberAliasOperation;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation\Authorization;
use Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation;
use Io\Token\Proto\Common\Member\MemberRemoveKeyOperation;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\Transaction;
use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transfer\TransferPayload;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Io\Token\Proto\Gateway\GetTokensRequest\Type;
use Tokenio\Exception\InvalidRealmException;
use Tokenio\Rpc\Client;
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
    public function aliases()
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
        $aliases = $this->client->getAliases();
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
     */
    public function getBalance($accountId, $keyLevel)
    {
        return $this->client->getBalance($accountId, $keyLevel);
    }

    /**
     * Returns linking information for the specified bank id.
     *
     * @param string $bankId the bank id
     * @return BankInfo linking information
     */
    public function getBankInfo($bankId)
    {
        return $this->client->getBankInfo($bankId);
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
     */
    public function removeAliases($aliasList)
    {
        $operations = [];
        foreach ($aliasList as $alias) {
            $aliasOperation = new MemberAliasOperation();
            $aliasOperation->setAliasHash(Util::hashAlias($alias));

            $operation = new MemberOperation();
            $operation->setRemoveAlias($aliasOperation);

            $operations[] = $operation;
        }
        $latest = $this->client->getMember($this->getMemberId());
        $updatedMember = $this->client->updateMember($latest, $operations, []);
        return $updatedMember !== null;
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
     * @param \Tokenio\TokenRequest $tokenRequest token request
     * @return string token request id
     */
    public function storeTokenRequest($tokenRequest)
    {
        return $this->client->storeTokenRequest(
            $tokenRequest->getTokenPayload(),
            $tokenRequest->getOptions(),
            $tokenRequest->getUserRefId(),
            $tokenRequest->getCustomizationId());
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
        return $this->removeKeys([$keyId]);
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
        return $this->client->deleteMember();
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
     * Retrieves a blob from the server.
     *
     * @param string $blobId id of the blob
     * @return Blob
     */
    public function getBlob($blobId)
    {
        return $this->client->getBlob($blobId);
    }

    /**
     * Creates a new transfer token builder.
     *
     * @param double $amount transfer amount
     * @param string $currency currency code, e.g. "USD"
     * @return TransferTokenBuilder token returned by the server
     *
    public function createTransferToken($amount, $currency)
    {
        return new TransferTokenBuilder($this, $amount, $currency);
    }
     */

    /**
     * Creates an access token built from a given {@link AccessTokenBuilder}.
     *
     * @param TokenPayload $tokenPayload to create access token from
     * @return Token
     *
    public function createAccessToken($tokenPayload)
    {
        return $this->client->createAccessToken($tokenPayload);
    }
     */

    /**
     * Creates an access token built from a given {@link AccessTokenBuilder}.
     *
     * @param TokenPayload $tokenPayload to create access token from
     * @param string $tokenRequestId token request id
     * @return Token
     */
    public function createAccessTokenForTokenRequestId($tokenPayload, $tokenRequestId)
    {
        return $this->client->createAccessTokenForTokenRequestId($tokenPayload, $tokenRequestId);
    }

    /**
     * Looks up access tokens owned by the member.
     *
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @return PagedList tokens owned by the member
     */
    public function getAccessTokens($offset, $limit)
    {
        return $this->client->getTokens(Type::ACCESS, $offset, $limit);
    }

    /**
     * Endorses the token by signing it. The signature is persisted along
     * with the token.
     *
     * <p>If the key's level is too low, the result's status is MORE_SIGNATURES_NEEDED
     * and the system pushes a notification to the member prompting them to use a
     * higher-privilege key.
     *
     * @param Token $token to endorse
     * @param int $keyLevel key level to be used to endorse the token
     * @return TokenOperationResult result of endorse token
     *
    public function endorseToken($token, $keyLevel)
    {
        return $this->client->endorseToken($token, $keyLevel);
    }
     */

    /**
     * Creates a new web-app customization.
     *
     * @param string $displayName display name
     * @param Payload $logo blob payload of the logo
     * @param string $consentText consent text
     * @param array $colors a string dictionary that describes color schemes
     * @return string customization id
     */
    public function createCustomization($displayName=null, $logo=null, $consentText=null, $colors=[])
    {
        return $this->client->createCustomization($displayName, $logo, $consentText, $colors);
    }

    /**
     * Looks up transfer tokens owned by the member.
     *
     * @param offset optional offset to start at
     * @param limit max number of records to return
     * @return PagedList transfer tokens owned by the member
     */
    public function getTransferTokens($offset, $limit)
    {

        return $this->client->getTokens(TRANSFER, $offset,$limit);
    }

    /**
     * Creates a test bank account in a fake bank and links the account.
     *
     * @param balance account balance to set
     * @param currency currency code, e.g. "EUR"
     * @return Account the linked account
     */
    public function createTestBankAccount($balance, $currency)
    {
        $money = new Money();
        $money->setValue($balance)->setCurrency($currency);
        $accountProto  = $this->client->createAndLinkTestBankAccount($money);

        $account = new Account($this, $accountProto, $this->client);
        return $account;
    }

    /**
     * Creates a test bank account in a fake bank and links the account.
     *
     * @param balance account balance to set
     * @param currency currency code, e.g. "EUR"
     * @return \Io\Token\Proto\Common\Account\Account the linked account
     */
    public function createAndLinkTestBankAccount($money)
    {
        return $this->client->createAndLinkTestBankAccount($money);
    }

    /**
     * Sets security metadata included in all requests.
     *
     * @param securityMetadata security metadata
     */
    public function setTrackingMetaData($securityMetadata)
    {
        $this->client->setTrackingMetaData($securityMetadata);
    }

    /**
     * Clears security metadata.
     */
    public function clearTrackingMetaData()
    {
        $this->client->clearTrackingMetaData();
    }

    /**
     * Trigger a step up notification for balance requests.
     *
     * @param string[] accountIds list of account ids
     * @return int
     */
    public function triggerBalanceStepUpNotification($accountIds)
    {
        return $this->client->triggerBalanceStepUpNotification($accountIds);
    }

    /**
     * Trigger a step up notification for transaction requests.
     *
     * @param string account id
     * @return int
     */
    public function triggerTransactionStepUpNotification($accountId)
    {
        return $this->client->triggerTransactionStepUpNotification($accountId);
    }

    /**
     * Resolves transfer destinations for the given account id.
     *
     * @param $accountId
     * @return RepeatedField transfer endpoints
     */
    public function getTransferDestinations($accountId)
    {
        return $this->client->resolveTransferDestinations($accountId);
    }
}
