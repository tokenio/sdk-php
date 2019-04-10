<?php


namespace Sample\Tokenio;


use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Token\TokenRequestPayload;
use Tokenio\Member;
use Tokenio\TokenClient;
use Tokenio\TokenRequest;
use Tokenio\Util\Strings;

final class StoreAndRetrieveTokenRequestSample
{
    /**
     * Stores a transfer token request.
     *
     * @param $payee Member : Payee Token member (the member requesting the transfer token be created)
     * @return string: a token request id
     */
    public static function storeTransferTokenRequest($payee)
    {
        $alias = new Alias();
        $alias->setValue("payer-alias@token.io")->setType(Alias\Type::EMAIL);
        $transferBuilder = TokenRequest::transferTokenRequestBuilder(100, "EUR");
        $tokenRequest = $transferBuilder->setToMemberId($payee->getMemberId())
                            ->setDescription("Book purchase")
                            ->setRedirectUrl("https://token.io/callback")
                            ->setFromAlias($alias)
                            ->setBankId("iron")
                            ->setCsrfToken(Strings::generateNonce())
                            ->build();

        return $payee->storeTokenRequest($tokenRequest);
    }

    /**
     * Stores an access token request.
     *
     * @param $grantee Member: Token member requesting the access token be created
     * @return string: a token request id
     */
    public static function storeAccessTokenRequest($grantee)
    {
        $alias = new Alias();
        $alias->setValue("payer-alias@token.io")->setType(Alias\Type::EMAIL);

        $transferBuilder = TokenRequest::accessTokenRequestBuilder(
            TokenRequestPayload\AccessBody\ResourceType::ACCOUNTS,
                      TokenRequestPayload\AccessBody\ResourceType::BALANCES);

        $tokenRequest = $transferBuilder->setToMemberId($grantee->getMemberId())
                        ->setRedirectUrl("https://token.io/callback")
                        ->setFromAlias($alias)
                        ->setBankId("iron")
                        ->setCsrfToken(Strings::generateNonce())
                        ->build();

        return $grantee->storeTokenRequest($tokenRequest);
    }

    /**
     * Retrieves a token request.
     *
     * @param $tokenClient TokenClient
     * @param $requestId string
     * @return mixed: token request that was stored with the request id
     */
    public static function retrieveTokenRequest($tokenClient, $requestId)
    {
        return $tokenClient->retrieveTokenRequest($requestId);
    }
}