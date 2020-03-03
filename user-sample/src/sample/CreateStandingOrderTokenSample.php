<?php

namespace Tokenio\Sample\User;

use Exception;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Tokenio\User\Member;
use Tokenio\User\Util\Util;
use Tokenio\Util\Strings;

class CreateStandingOrderTokenSample
{
    /**
     * @param $payer Member
     * @param $payeeAlias Alias
     * @param $keyLevel int
     * @return Token
     * @throws Exception
     */
    public static function createStandingOrderToken($payer, $payeeAlias, $keyLevel)
    {
        $purchaseId = Strings::generateNonce();

        $sepaDestination = new TransferDestination\Sepa();
        $sepaDestination->setBic("XUIWC2489")->setIban("DE89 3704 0044 0532 0130 00");

        $destination = new TransferDestination();
        $destination->setSepa($sepaDestination);

        $builder = $payer->createStandingOrderTokenBuilder(null,
            10.0, "EUR", "DAIL",
            date('Y-m-d'), date('Y-m-d', strtotime('+7 days')))
            ->setAccountId($payer->getAccounts()[0]->id())
            ->setToAlias($payeeAlias)
            ->setDescription("Credit card statement payment")
            ->setRefId($purchaseId)
            ->addDestination($destination);

        $result = $payer->prepareStandingOrderToken($builder);

        $standingOrderToken = $payer->createToken($result->getTokenPayload(),null, $keyLevel);
        return $standingOrderToken;
    }
}