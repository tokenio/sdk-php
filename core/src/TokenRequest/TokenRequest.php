<?php

namespace Tokenio;

use Io\Token\Proto\Common\Account\BankAccount;
use Io\Token\Proto\Common\Token\BulkTransferBody\Transfer;
use Io\Token\Proto\Common\Token\TokenRequestOptions;
use Io\Token\Proto\Common\Token\TokenRequestPayload;
use Io\Token\Proto\Common\Token\TokenRequestPayload\AccessBody\ResourceType;
use Io\Token\Proto\Common\Transferinstructions\CustomerData;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use PHPUnit\Runner\Exception;
use ReflectionException;
use Tokenio\TokenRequest\Builder\AccessBuilder;
use Tokenio\TokenRequest\Builder\BulkTransferBuilder;
use Tokenio\TokenRequest\Builder\StandingOrderBuilder;
use TokenRequestPayload\AccessBody\AccountResourceList\AccountResource;
use Io\Token\Proto\Common\Token\TokenRequestPayload\AccessBody\AccountResourceType;

class TokenRequest
{
    /**
     * @var TokenRequestPayload
     */
    private $tokenRequestPayload;

    /**
     * @var TokenRequestOptions
     */
    private $tokenRequestOptions;

    /**
     * TokenRequest constructor.
     *
     * @param TokenRequestPayload $tokenRequestPayload
     * @param TokenRequestOptions $tokenRequestOptions
     */
    public function __construct($tokenRequestPayload = null, $tokenRequestOptions = null)
    {
        if($tokenRequestPayload === null)
        {
            throw new Exception("Null tokenRequestPayload");
        }
        $this->tokenRequestPayload = $tokenRequestPayload;

        if($tokenRequestOptions === null)
        {
            throw new Exception("Null tokenRequestOptions");
        }
        $this->tokenRequestOptions = $tokenRequestOptions;
    }

    /**
     * @param $tokenRequestPayload
     * @param $tokenRequestOptions
     * @return TokenRequest
     */
    public static function fromProtos($tokenRequestPayload, $tokenRequestOptions)
    {
        return new TokenRequest($tokenRequestPayload, $tokenRequestOptions);
    }

    /**
     * Create a new Builder instance for an access token request.
     *
     * @param int[] $resources
     * @param TokenRequestPayload\AccessBody\AccountResourceList $list
     * @return AccessBuilder
     * @throws ReflectionException
     */
    public static function accessTokenRequestBuilder($resources = null, $list = null)
    {
        return new AccessBuilder($resources, $list);
    }

    /**
     * @param string $bankId
     * @param BankAccount $account
     * @param CustomerData $data
     * @return AccessBuilder
     * @throws ReflectionException
     */
    public function fundsConfirmationRequestBuilder($bankId, $account, $data = null){
        $resource = new TokenRequestPayload\AccessBody\AccountResourceList\AccountResource();
        $resource->setBankAccount($account)->setType(AccountResourceType::ACCOUNT_FUNDS_CONFIRMATION);

        if(!empty($data)){
            $resource->setCustomerData($data);
        }

        $accountResource =  new TokenRequestPayload\AccessBody\AccountResourceList();
        $accountResource->setResources([$resource]);

        $accessBuilder = new AccessBuilder(null,$accountResource);
        return $accessBuilder->setBankId($bankId);
    }

    /**
     * Create a new Builder instance for a transfer token request.
     *
     * @param double $amount
     * @param string $currency
     * @return TransferBuilder
     */
    public static function transferTokenRequestBuilder($amount, $currency)
    {
        return new TransferBuilder($amount, $currency);
    }

    /**
     * Create a new Builder instance for a standing order token request.
     *
     * @param double $amount amount per charge
     * @param string $currency currency per charge
     * @param string $frequency frequency of the standing order. ISO 20022: DAIL, WEEK, TOWK,
     *                  MNTH, TOMN, QUTR, SEMI, YEAR
     * @param string $startDate start date of the standing order. ISO 8601: YYYY-MM-DD or YYYYMMDD.
     * @param string $endDate end date of the standing order. ISO 8601: YYYY-MM-DD or YYYYMMDD.
     * @param TransferDestination $destinations destination account of the standing order
     * @return StandingOrderBuilder
     */
    public static function standingOrderRequestBuilder(
        $amount,
        $currency,
        $frequency,
        $startDate,
        $endDate,
        $destinations)
    {
        return new StandingOrderBuilder(
            $amount,
            $currency,
            $frequency,
            $startDate,
            $endDate,
            $destinations
        );
    }

    /**
     * Create a new Builder instance for a bulk transfer token request.
     *
     * @param Transfer[] $transfers list of transfers
     * @param double $totalAmount total amount irrespective of currency. Used for redundancy check.
     * @return BulkTransferBuilder
     */
    public static function bulkTransferRequestBuilder($transfers, $totalAmount)
    {
        return new BulkTransferBuilder($transfers, $totalAmount);
    }

    /**
     * @return TokenRequestPayload|null
     */
    public function getTokenRequestPayload()
    {
        return $this->tokenRequestPayload;
    }

    /**
     * @return TokenRequestOptions
     */
    public function getTokenRequestOptions()
    {
        return $this->tokenRequestOptions;
    }
}