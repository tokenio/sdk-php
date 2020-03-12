<?php
namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TransferBody;
use Tokenio\User\TokenClient;
use Tokenio\Util\Strings;

class NotifySample
{
    /**
     * @param $tokenClient TokenClient
     * @param $payee \Tokenio\User\Member
     * @param $payerAlias
     * @return int
     * @throws \Exception
     */
    public static function notifyPaymentRequest($tokenClient, $payee, $payerAlias)
    {
        $cartId = Strings::generateNonce();
        $body = new TransferBody();
        $body->setAmount("100.00")->setCurrency("EUR");

        $member1 = new TokenMember();
        $member1->setAlias($payerAlias);
        $member2 = new TokenMember();
        $member2->setAlias($payee->firstAlias());
        $paymentRequest = new \Io\Token\Proto\Common\Token\TokenPayload();
        $paymentRequest->setDescription("Sample payment request")
            ->setFrom($member1)->setTo($member2)->setTransfer($body)->setRefId($cartId);

        $status = $tokenClient->notifyPaymentRequest($paymentRequest);
        return $status;
    }
}