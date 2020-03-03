<?php

namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Account\BankAccount\FasterPayments;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Token\TokenRequestPayload;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Tokenio\Tpp\Member;
use Tokenio\Tpp\TokenClient;
use Tokenio\TokenRequest;
use Tokenio\Tpp\TokenRequest\TokenRequestTransferDestinationsCallbackParameters;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;

final class StoreAndRetrieveTokenRequestSample
{
    /**
     * Stores a transfer token request.
     *
     * @param $payee  Member: Payee Token member (the member requesting the transfer token be created)
     * @return string: a token request id
     * @throws \Exception
     */
    public static function storeTransferTokenRequest($payee)
    {
        $alias = new Alias();
        $alias->setValue("payer-alias@token.io")->setType(Alias\Type::EMAIL);
        $tokenRequest = TokenRequest::transferTokenRequestBuilder(100, "EUR")
            ->setToMemberId($payee->getMemberId())
            ->setDescription("Book purchase")
            ->setRedirectUrl("https://token.io/callback")
            ->setFromAlias($alias)
            ->setBankId("iron")
            ->setCsrfToken(Strings::generateNonce())
            ->build();
        return $payee->storeTokenRequest($tokenRequest);
    }


    /**
     * @param $payee Member
     * @param $setTransferDestinationsCallback string
     * @return string
     * @throws \Exception
     */
    public static function storeTransferTokenRequestWithDestinationsCallback($payee, $setTransferDestinationsCallback)
    {
        $alias = new Alias();
        $alias->setValue("payer-alias@token.io")
            ->setType(Alias\Type::EMAIL);

        $tokenRequest = TokenRequest::transferTokenRequestBuilder(250, "EUR")
            ->setToMemberId($payee->getMemberId())
            ->setDescription("Bank Purchase")
            ->setSetTransferDestinationsUrl($setTransferDestinationsCallback)
            ->setRedirectUrl("https://tpp-sample.com/callback")
            ->setFromAlias($alias)
            ->setBankId("iron")
            ->setCsrfToken(Strings::generateNonce())
            ->build();

        $requestId = $payee->storeTokenRequest($tokenRequest);

        return $requestId;
    }


    /**
     * Stores an access token request.
     *
     * @param $grantee Member: Token member requesting the access token be created
     * @return string
     * @throws \ReflectionException
     */
    public static function storeAccessTokenRequest($grantee)
    {
        $alias = new Alias();
        $alias->setValue("grantor-alias@token.io")->setType(Alias\Type::EMAIL);
        $resources = array();
        $resources[] = TokenRequestPayload\AccessBody\ResourceType::ACCOUNTS;
        $resources[] = TokenRequestPayload\AccessBody\ResourceType::BALANCES;
        $tokenRequest = TokenRequest::accessTokenRequestBuilder($resources)
            ->setToMemberId($grantee->getMemberId())
            ->setRedirectUrl("https://token.io/callback")
            ->setFromAlias($alias)
            ->setBankId("iron")
            ->setCsrfToken(Strings::generateNonce())
            ->build();
        return $grantee->storeTokenRequest($tokenRequest);
    }

    /**
     * Retrieves a token request.
     * @param $tokenClient TokenClient
     * @param $requestId string
     * @return mixed: token request that was stored with the request id
     */
    public static function retrieveTokenRequest($tokenClient, $requestId)
    {
        return $tokenClient->retrieveTokenRequest($requestId);
    }

    /**
     * @param $payee Member
     * @param $requestId string
     * @param $tokenClient TokenClient
     * @param $setTransferDestinationsCallback
     * @throws \Exception
     */
    public static function setTokenRequestTransferDestinations($payee, $requestId, $tokenClient, $setTransferDestinationsCallback)
    {
        /* @var TokenRequestTransferDestinationsCallbackParameters $params */
        $params = $tokenClient->parseSetTransferDestinationsUrl($setTransferDestinationsCallback);

        /* @var $transferDestinations \Io\Token\Proto\Common\Transferinstructions\TransferDestination[] */
        $transferDestinations = array();
        $des = $params->getSupportedTransferDestinationTypes();

        if($params->getSupportedTransferDestinationTypes())
        {
            $fasterPayment = new TransferDestination\FasterPayments();
            $fasterPayment->setSortCode(Strings::generateNonce());
            $fasterPayment->setAccountNumber(Strings::generateNonce());

            $destination = new TransferDestination();
            $destination->setFasterPayments($fasterPayment);
            $transferDestinations[] = $destination;
        }
        else{
            $sepaDestination = new TransferDestination\Sepa();
            $sepaDestination->setBic(Strings::generateNonce())->setIban(Strings::generateNonce());
            $destination = new TransferDestination();
            $destination->setSepa($sepaDestination);
            $transferDestinations[] = $destination;
        }
        $payee->setTokenRequestTransferDestinations($requestId, $transferDestinations);
    }
}