<?php

namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Eidas\VerifyEidasPayload;
use Io\Token\Proto\Common\Security\Key\Algorithm;
use Io\Token\Proto\Common\Security\PrivateKey;
use Io\Token\Proto\Common\Token\Policy\Signer;
use Io\Token\Proto\Gateway\NormalizeAliasRequest;
use ParagonIE\Sodium\Crypto;
use Tokenio\Security\TokenCryptoEngine;
use Tokenio\Tpp\TokenClient;
use Tokenio\Util\Util;

class VerifyEidasSample
{


    /**
     * @param $client TokenClient
     * @param $tppAuthNumber string
     * @param $certificate string
     * @param $bankId string
     * @param $privateKey PrivateKey
     * @throws \Exception
     */
    public static function verifyEidas($client, $tppAuthNumber, $certificate, $bankId, $privateKey)
    {


    }
}
