<?php


namespace Tokenio\User;

use ExceptionInAssertPreConditionsTest;
use http\Message\Body;
use Io\Token\Proto\Common\Account\BankAccount;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Providerspecific\ProviderTransferMetadata;
use Io\Token\Proto\Common\Token\ActingAs;
use Io\Token\Proto\Common\Token\StandingOrderBody;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequest;
use Io\Token\Proto\Common\Token\TokenRequestPayload;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Io\Token\Proto\Common\Transferinstructions\TransferInstructions;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Tokenio\Exception\IllegalArgumentException;
use Tokenio\TokenRequest\Builder\StandingOrderBuilder;
use Tokenio\User\Util\Util;
use Tokenio\Util\Strings;

class StandingOrderTokenBuilder
{



    const REF_ID_MAX_LENGTH = 18;

    /* @var TokenPayload $payload */
    private $payload;

    /**
     * @var Logger
     */
    private $logger;


    /**
     * StandingOrderTokenBuilder constructor.
     * @param $tokenRequest TokenRequest
     * @param $member Member
     * @param $amount double
     * @param $currency string
     * @param $frequency string
     * @param $startDate string
     * @param $endDate string
     * @throws \Exception
     */
    public function __construct($tokenRequest, $member= null, $amount= null, $currency= null, $frequency= null, $startDate= null, $endDate= null)
    {
        if($tokenRequest === null) {
            $newMember = new TokenMember();
            $newMember->setId($member->getMemberId());

            $this->payload = new TokenPayload();
            $this->payload->setVersion("1.0")->setFrom($newMember);

            /* @var $body StandingOrderBody */
            $body = new StandingOrderBody();
            $body->setCurrency($currency)
                ->setAmount(strval($amount))
                ->setFrequency($frequency)
                ->setStartDate($startDate);

            if ($endDate !== null) {
                $body->setEndDate($endDate);
            }
            $this->payload->setStandingOrder($body);

            /* @var $aliases Alias[] */
            $aliases = $member->aliases();
            if (!empty($aliases)) {
                $this->payload->getFrom()->setAlias($aliases[0]);
            }
        }
        else{
            if($tokenRequest->getRequestPayload()->getRequestBody() !== "STANDING_ORDER_BODY")
            {
                throw new IllegalArgumentException("Require token request with standing order body.");
            }

            if($tokenRequest->getRequestPayload()->getTo() === null)
            {
                throw new IllegalArgumentException("No payee on token request");
            }
            /* @var $body StandingOrderBody */
            $body = $tokenRequest->getRequestPayload()
                ->getStandingOrderBody();

            $this->payload = new TokenPayload();
            $this->payload->setVersion("1.0")
                ->setRefId($tokenRequest->getRequestPayload()->getRefId())
                ->setTokenRequestId($tokenRequest->getId())
                ->setFrom($tokenRequest->getRequestOptions()->getFrom())
                ->setTo($tokenRequest->getRequestPayload()->getTo())
                ->setDescription($tokenRequest->getRequestPayload()->getDescription())
                ->setReceiptRequested($tokenRequest->getRequestOptions()->getReceiptRequested())
                ->setStandingOrder($body);

            if($tokenRequest->getRequestPayload()->getActingAs() !== null)
            {
                $this->payload->setActingAs($tokenRequest->getRequestPayload()->getActingAs());
            }
        }

        $this->logger = new Logger('Tokenio\User\StandingOrderTokenBuilder');
        $this->logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
    }

    /**
     * @param $expireAtMs int
     * @return StandingOrderTokenBuilder
     */
    public function setExpireAtMs($expireAtMs)
    {
        $this->payload->setExpiresAtMs($expireAtMs);
        return $this;
    }

    /**
     * @param $effectiveAtMs int
     * @return StandingOrderTokenBuilder
     */
    public function setEffectiveAtMs($effectiveAtMs)
    {
        $this->payload->setEffectiveAtMs($effectiveAtMs);
        return $this;
    }

    /**
     * @param $endorseUntilMs int
     * @return StandingOrderTokenBuilder
     */
    public function setEndorseUntilMs($endorseUntilMs)
    {
        $this->payload->setEndorseUntilMs($endorseUntilMs);
        return $this;
    }

    /**
     * @param $description string
     * @return StandingOrderTokenBuilder
     */
    public function setDescription($description)
    {
        $this->payload->setDescription($description);
        return $this;
    }

    /**
     * @param $source TransferEndpoint
     * @return StandingOrderTokenBuilder
     */
    public function setSource($source)
    {

        if ($this->payload->getStandingOrder()->getInstructions() === null) {
            $this->payload->getStandingOrder()->setInstructions(new TransferInstructions());
        }
        $this->payload->getStandingOrder()->getInstructions()->setSource($source);
        return $this;
    }

    /**
     * @param $accountId string
     * @return StandingOrderTokenBuilder
     * @throws IllegalArgumentException
     */
    public function setAccountId($accountId)
    {
        if($this->payload->getFrom()->getId() === null || $this->payload->getFrom()->getId() === "")
        {
            throw new IllegalArgumentException();
        }
        $token = new BankAccount\Token();
        $token->setAccountId($accountId);
        $token->setMemberId($this->payload->getFrom()->getId());

        $account = new BankAccount();
        $account->setToken($token);

        $endPoint = new TransferEndpoint();
        $endPoint->setAccount($account);


        $this->setSource($endPoint);
        return $this;
    }

    /**
     * @param $destination TransferDestination
     * @return StandingOrderTokenBuilder
     */
    public function addDestination($destination)
    {
        if ($this->payload->getStandingOrder()->getInstructions() === null) {
            $this->payload->getStandingOrder()->setInstructions(new TransferInstructions());
        }
        $this->payload->getStandingOrder()->getInstructions()->getTransferDestinations()[] = $destination;
        return $this;
    }

    /**
     * @param $toAlias Alias
     * @return StandingOrderTokenBuilder
     */
    public function setToAlias($toAlias)
    {
        $to = new TokenMember();
        $to->setAlias($toAlias);
        $this->payload->setTo($to);
        return $this;
    }

    /**
     * @param $toMemberId string
     * @return StandingOrderTokenBuilder
     */
    public function setToMemberId($toMemberId)
    {
        $to = new TokenMember();
        $to->setId($toMemberId);
        $this->payload->setTo($to);
        return $this;
    }

    /**
     * @param $refId string
     * @return StandingOrderTokenBuilder
     * @throws IllegalArgumentException
     */
    public function setRefId($refId)
    {
        if(strlen($refId) > self::REF_ID_MAX_LENGTH)
        {
            throw new IllegalArgumentException(sprintf("The length of the refId is at most %s, got: %s ",self::REF_ID_MAX_LENGTH, strlen($refId)));
        }
        $this->payload->setRefId($refId);
        return $this;
    }

    /**
     * @param $actingAs ActingAs
     * @return StandingOrderTokenBuilder
     */
    public function setActingAs($actingAs)
    {
        $this->payload->setActingAs($actingAs);
        return $this;
    }

    /**
     * @param $tokenRequestID string
     * @return StandingOrderTokenBuilder
     */
    public function setTokenRequestId($tokenRequestID)
    {
        $this->payload->setTokenRequestId($tokenRequestID);
        return $this;
    }

    /**
     * @param $receiptRequested boolean
     * @return StandingOrderTokenBuilder
     */
    public function setReceiptRequested($receiptRequested)
    {
        $this->payload->setReceiptRequested($receiptRequested);
        return $this;
    }

    /**
     * @param $metadata ProviderTransferMetadata
     * @return StandingOrderTokenBuilder
     */
    public function setProviderTransferMetadata($metadata)
    {
        $this->payload->getStandingOrder()->getInstructions()->getMetadata()->setProviderTransferMetadata($metadata);
        return $this;
    }

    /**
     * @param $ultimateCreditor string
     * @return StandingOrderTokenBuilder
     */
    public function setUltimateCreditor($ultimateCreditor)
    {
         $this->payload->getStandingOrder()
            ->getInstructions()
            ->getMetadata()
            ->setUltimateCreditor($ultimateCreditor);

         return $this;
    }

    /**
     * @param $ultimateDebtor string
     * @return StandingOrderTokenBuilder
     */
    public function setUltimateDebtor($ultimateDebtor)
    {
        $this->payload->getStandingOrder()
            ->getInstructions()
            ->getMetadata()
            ->setUltimateDebtor($ultimateDebtor);
        return $this;
    }

    /**
     * @param $purposeCode string
     * @return StandingOrderTokenBuilder
     */
    public function setPurposeCode($purposeCode)
    {
        $this->payload->getStandingOrder()
            ->getInstructions()
            ->getMetadata()
            ->setPurposeCode($purposeCode);
        return $this;
    }

    /**
     * @return TokenPayload
     */
    public function buildPayload()
    {
        if(empty($this->payload->getRefId()))
        {
            $this->logger->warn("refId is not set. A random ID will be used.");
            $this->payload->setRefId(Strings::generateNonce());
        }

        return $this->payload;
    }
}