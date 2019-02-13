<?php

namespace Tokenio;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Token\AccessBody;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use Tokenio\Exception\IllegalArgumentException;
use Tokenio\Util\Strings;

class AccessTokenBuilder
{
    /**
     * @var TokenPayload
     */
    private $payload;

    private function __construct($payload = null)
    {
        if ($payload === null) {
            $this->payload = new TokenPayload();
            $this->payload->setVersion('1.0')
                ->setRefId(Strings::generateNonce())
                ->setAccess(new AccessBody())
                ->setFrom(new TokenMember())
                ->setTo(new TokenMember());
        } else {
            $this->payload = $payload;
        }
    }

    /**
     * Creates an instance of {@link AccessTokenBuilder}.
     *
     * @param Alias $redeemerAlias redeemer alias
     * @return AccessTokenBuilder
     */
    public static function createWithAlias($redeemerAlias)
    {
        $tokenBuilder = new AccessTokenBuilder();
        return $tokenBuilder->aliasTo($redeemerAlias);
    }

    /**
     * Creates an instance of {@link AccessTokenBuilder}.
     *
     * @param string $redeemerMemberId redeemer member id
     * @return AccessTokenBuilder
     */
    public static function createWithRedeemerId($redeemerMemberId)
    {
        $tokenBuilder = new AccessTokenBuilder();
        return $tokenBuilder->redeemerTo($redeemerMemberId);
    }

    /**
     * Sets "to" field on the payload.
     *
     * @param Alias $redeemerAlias redeemer alias
     * @return AccessTokenBuilder
     */
    public function aliasTo($redeemerAlias)
    {
        $this->payload->getTo()->setAlias($redeemerAlias);
        return $this;
    }

    /**
     * Sets "to" field on the payload.
     *
     * @param string $redeemerMemberId redeemer member id
     * @return AccessTokenBuilder
     */
    public function redeemerTo($redeemerMemberId)
    {
        $this->payload->getTo()->setId($redeemerMemberId);
        return $this;
    }

    /**
     * Creates an instance of AccessTokenBuilder from an existing token payload.
     *
     * @param TokenPayload $payload payload to initialize from
     * @return AccessTokenBuilder
     */
    public static function fromPayload($payload)
    {
        $payload->setAccess(new AccessBody());
        $payload->setRefId(Strings::generateNonce());
        return new AccessTokenBuilder($payload);
    }

    /**
     * Grants access to ALL resources (aka wildcard permissions).
     *
     * @return AccessTokenBuilder
     */
    public function forAll()
    {
        return $this->forAllAccounts()
            ->forAllAddresses()
            ->forAllBalances()
            ->forAllTransactions()
            ->forAllTransferDestinations();
    }

    /**
     * Grants access to all addresses.
     *
     * @return AccessTokenBuilder
     */
    public function forAllAddresses()
    {
        $addresses = new AccessBody\Resource\AllAddresses();
        $resource = new AccessBody\Resource();
        $resource->setAllAddresses($addresses);

        self::addResource($this->payload, $resource);

        return $this;
    }

    /**
     * Grants access to a given {@code addressId}.
     *
     * @param string $addressId address ID to grant access to
     * @return AccessTokenBuilder
     */
    public function forAddress($addressId)
    {
        $address = new AccessBody\Resource\Address();
        $address->setAddressId($addressId);

        $resource = new AccessBody\Resource();
        $resource->setAddress($address);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to all accounts.
     *
     * @return AccessTokenBuilder
     */
    public function forAllAccounts()
    {
        $allAccounts = new AccessBody\Resource\AllAccounts();
        $resource = new AccessBody\Resource();
        $resource->setAllAccounts($allAccounts);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to all accounts at a given bank.
     *
     * @param string $bankId the bank id
     * @return AccessTokenBuilder
     */
    public function forAllAccountsAtBank($bankId)
    {
        $allAccounts = new AccessBody\Resource\AllAccountsAtBank();
        $allAccounts->setBankId($bankId);

        $resource = new AccessBody\Resource();
        $resource->setAllAccountsAtBank($allAccounts);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to a given $accountId.
     *
     * @param string $accountId account ID to grant access to
     * @return AccessTokenBuilder
     */
    public function forAccount($accountId)
    {
        $account = new AccessBody\Resource\Account();
        $account->setAccountId($accountId);

        $resource = new AccessBody\Resource();
        $resource->setAccount($account);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to all transactions.
     *
     * @return AccessTokenBuilder
     */
    public function forAllTransactions()
    {
        $allTransactions = new AccessBody\Resource\AllAccountTransactions();
        $resource = new AccessBody\Resource();

        $resource->setAllTransactions($allTransactions);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to all transactions at a given bank.
     *
     * @param string $bankId the bank id
     * @return AccessTokenBuilder
     */
    public function forAllTransactionsAtBank($bankId)
    {
        $allTransactions = new AccessBody\Resource\AllTransactionsAtBank();
        $allTransactions->setBankId($bankId);

        $resource = new AccessBody\Resource();
        $resource->setAllTransactionsAtBank($allTransactions);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to a given account transactions.
     *
     * @param string $accountId account ID to grant access to transactions
     * @return AccessTokenBuilder
     */
    public function forAccountTransactions($accountId)
    {
        $accountTransactions = new AccessBody\Resource\AccountTransactions();
        $accountTransactions->setAccountId($accountId);

        $resource = new AccessBody\Resource();
        $resource->setTransactions($accountTransactions);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to all balances.
     *
     * @return AccessTokenBuilder
     */
    public function forAllBalances()
    {
        $allBalances = new AccessBody\Resource\AllAccountBalances();
        $resource = new AccessBody\Resource();
        $resource->setAllBalances($allBalances);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to all balances at a given bank.
     *
     * @param string $bankId the bank id
     * @return AccessTokenBuilder
     */
    public function forAllBalancesAtBank($bankId)
    {
        $allBalances = new AccessBody\Resource\AllBalancesAtBank();
        $allBalances->setBankId($bankId);

        $resource = new AccessBody\Resource();
        $resource->setAllBalancesAtBank($allBalances);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to a given account balances.
     *
     * @param string $accountId account ID to grant access to balances
     * @return AccessTokenBuilder
     */
    public function forAccountBalances($accountId)
    {
        $accBalance = new AccessBody\Resource\AccountBalance();
        $accBalance->setAccountId($accountId);

        $resource = new AccessBody\Resource();
        $resource->setBalance($accBalance);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to all transfer destinations.
     *
     * @return AccessTokenBuilder
     */
    public function forAllTransferDestinations()
    {
        $allDestinations = new AccessBody\Resource\AllTransferDestinations();
        $resource = new AccessBody\Resource();
        $resource->setAllTransferDestinations($allDestinations);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to all transfer destinations at a given bank.
     *
     * @param string $bankId bank id
     * @return AccessTokenBuilder
     */
    public function forAllTransferDestinationsAtBank($bankId)
    {
        $bankDestinations = new AccessBody\Resource\AllTransferDestinationsAtBank();
        $bankDestinations->setBankId($bankId);

        $resource = new AccessBody\Resource();
        $resource->setAllTransferDestinationsAtBank($bankDestinations);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Grants access to all transfer destinations at the given account.
     *
     * @param string $accountId account id
     * @return AccessTokenBuilder
     */
    public function forTransferDestinations($accountId)
    {
        $destinations = new AccessBody\Resource\TransferDestinations();
        $destinations->setAccountId($accountId);

        $resource = new AccessBody\Resource();
        $resource->setTransferDestinations($destinations);

        self::addResource($this->payload, $resource);
        return $this;
    }

    /**
     * Adds new resource to Access on TokenPayload
     *
     * @param TokenPayload $payload token payload to modify
     * @param AccessBody\Resource $resource resource to add
     */
    private static function addResource($payload, $resource)
    {
        $resources = $payload->getAccess()->getResources();
        $resources[] = $resource;

        $payload->getAccess()->setResources($resources);
    }

    /**
     * Sets "from" field on the payload.
     *
     * @param string $memberId token member ID to set
     * @return AccessTokenBuilder
     */
    public function from($memberId)
    {
        $this->payload->getFrom()->setId($memberId);
        return $this;
    }

    /**
     * Sets "acting as" field on the payload.
     *
     * @param TokenPayload\ActingAs $actingAs entity the redeemer is acting on behalf of
     * @return AccessTokenBuilder
     */
    public function actingAs($actingAs)
    {
        $this->payload->setActingAs($actingAs);
        return $this;
    }

    /**
     * Builds the TokenPayload with all specified settings.
     *
     * @return TokenPayload
     * @throws Exception
     */
    public function build()
    {
        if (count($this->payload->getAccess()->getResources()) === 0) {
            throw new IllegalArgumentException('At least one access resource must be set');
        }

        return $this->payload;
    }
}
