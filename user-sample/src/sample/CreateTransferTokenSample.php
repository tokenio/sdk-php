<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Tokenio\User\Member;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;

class CreateTransferTokenSample
{
    /**
     * @param $payer Member
     * @param $payeeAlias Alias
     * @param $keyLevel
     * @return Token
     * @throws \Exception
     */
    public static function createTransferToken($payer, $payeeAlias, $keyLevel)
    {
        $purchaseId = Strings::generateNonce();

        $builder = $payer->createTransferToken(null,null, 10.0, "EUR")
            ->setAccountId($payer->getAccounts()[0]->id())
            ->setToAlias($payeeAlias)
            ->setDescription("Book-purchase")
            ->setRefId($purchaseId);

        $result = $payer->prepareTransferToken($builder);

        /** @var Token $transferToken */
        $transferToken = $payer->createToken($result->getTokenPayload(),null, $keyLevel);
        return $transferToken;
    }

    /**
     * @param $payer Member
     * @param $payeeId string
     * @return Token
     * @throws \Exception
     */
    public static function createTransferTokenWithOtherOptions($payer, $payeeId)
    {
        $now = round(microtime(true) * 1000);

        $builder = $payer->createTransferTokenBuilder(null,
            null, 120.0, "EUR")
            ->setAccountId($payer->getAccounts()[0]->id())
            ->setToMemberId($payeeId)
            ->setEffectiveAtMs($now+1000)
            ->setExpireAtMs($now + (300*1000))
            ->setRefId("a713c8a61994a749")
            ->setChargeAmount(10.0)
            ->setDescription("Book-purchase");

        $result = $payer->prepareTransferToken($builder);
        $transferToken = $payer->createToken($result->getTokenPayload(),null, Level::STANDARD);
        return $transferToken;
    }

    /**
     * @param $payer Member
     * @param $payeeAlias
     * @return Token
     * @throws \Exception
     */
    public static function createTransferTokenToDestination($payer, $payeeAlias)
    {
        $destination = new TransferDestination\Sepa();
        $destination->setBic("XUIWC2489")->setIban("DE89 3704 0044 0532 0130 00");

        $sepaDestination = new TransferDestination();
        $sepaDestination->setSepa($destination);

        $builder = $payer->createTransferTokenBuilder(null,null, 100.0,
            'EUR')->setAccountId($payer->getAccounts()[0]->id())
            ->setToAlias($payeeAlias)->addDestination($sepaDestination);

        $result = $payer->prepareTransferToken($builder);
        $transferToken = $payer->createToken($result->getTokenPayload(),null,Level::STANDARD);
        return $transferToken;
    }

    /**
     * @param $payer Member
     * @param $payeeAlias Alias
     * @return Token
     * @throws \Exception
     */
    public static function createTransferTokenScheduled($payer, $payeeAlias)
    {
        $purchaseId = Strings::generateNonce();

        $builder = $payer->createTransferTokenBuilder(null, null,
            10.0, "EUR")->setAccountId($payer->getAccounts()[0]->id())
            ->setToAlias($payeeAlias)->setDescription("Book purchase")
                ->setRefId($purchaseId)->setExecutionDate(date('Y-m-d', strtotime('+30 days')));

        $result = $payer->prepareTransferToken($builder);

        $transferToken = $payer->createToken($result->getTokenPayload(), null,Level::STANDARD);
        return $transferToken;
    }
}