<?php


namespace Tokenio\User;

use Io\Token\Proto\Common\Account\BankAccount;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Token\ActingAs;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequest;
use Io\Token\Proto\Common\Token\TokenRequestPayload;
use Io\Token\Proto\Common\Token\TransferBody;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Io\Token\Proto\Common\Transferinstructions\TransferInstructions;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Tokenio\Exception\IllegalArgumentException;
use Tokenio\Util\Strings;

class TransferTokenBuilder
{
    const REF_ID_MAX_LENGTH = 18;

    /* @var TokenPayload $payload */
    private $payload;

    /* @var Member */
    private $member;

    /**
     * @var Logger
     */
    private $logger;

    /* @var $tokenRequestId string */
    private $tokenRequestId;

    /**
     * TransferTokenBuilder constructor.
     * @param $tokenRequest TokenRequest
     * @param $member Member
     * @param $tokenPayload TokenPayload
     * @param $amount int
     * @param $currency string
     * @throws IllegalArgumentException
     * @throws \Exception
     */
    public function __construct($tokenRequest, $member, $tokenPayload= null, $amount=null, $currency= null)
    {
        if($tokenRequest !== null) {
            if($tokenRequest->getRequestPayload()->getRequestBody() !== "TRANSFER_BODY")
            {
                throw new IllegalArgumentException("Require token request with transfer body.");
            }
            if(! $tokenRequest->getRequestPayload()->getTo())
            {
                throw new IllegalArgumentException("No payee on token request");
            }

            $this->member = $member;
            $this->payload = new TokenPayload();

            $newMember = new TokenMember();
            /* @var $transferBody TokenRequestPayload\TransferBody */
            $transferBody = $tokenRequest->getRequestPayload()->getTransferBody();

            $newTransferBody = new TransferBody();
            $newTransferInstructions = new TransferInstructions();

            $newTransferBody->setLifetimeAmount($transferBody->getLifetimeAmount())
                ->setCurrency($transferBody->getCurrency())
                ->setAmount($transferBody->getAmount())
                ->setInstructions($transferBody->getInstructions() !== null
                    ? $transferBody->getInstructions()
                    : $newTransferInstructions->setDestinations($transferBody->getDestinations()));

            $this->payload->setVersion("1.0")
                ->setRefId($tokenRequest->getRequestPayload()->getRefId())
                ->setFrom($tokenRequest->getRequestOptions()->getFrom()!==null?
                    $tokenRequest->getRequestOptions()->getFrom()
                    : $newMember->setId($member->getMemberId()))
                ->setTo($tokenRequest->getRequestPayload()->getTo())
                ->setDescription($tokenRequest->getRequestPayload()->getDescription())
                ->setReceiptRequested($tokenRequest->getRequestOptions()->getReceiptRequested())
                ->setTokenRequestId($tokenRequest->getId())
                ->setTransfer($newTransferBody);

            if($tokenRequest->getRequestPayload()->getActingAs() !== null)
            {
                $this->payload->setActingAs($tokenRequest->getRequestPayload()->getActingAs());
            }

            $this->tokenRequestId = $tokenRequest->getId();
        }
        else
        {
            if($tokenPayload !== null)
            {
                if($tokenPayload->getBody() !== "TRANSFER") {
                    throw new IllegalArgumentException("Require token payload with transfer body.");
                }
                if(! $tokenPayload->getTo()){
                    throw new IllegalArgumentException("No payee on token payload");
                }
                $this->member = $member;
                $this->payload = $tokenPayload;

                if( $this->payload->getFrom() === null){
                    $newMember = new TokenMember();
                    $this->payload->setFrom($newMember->setId($member->getMemberId()));
                }
            }
            else {
                $this->member = $member;

                /* @var $transferBody TransferBody */
                $transferBody = new TransferBody();
                $transferBody->setCurrency($currency);
                $transferBody->setLifetimeAmount(strval($amount));

                $this->payload = new TokenPayload();
                $this->payload->setVersion("1.0")
                    ->setTransfer($transferBody);

                if ($member !== null) {
                    $this->from($member->getMemberId());
                    $aliases = $member->aliases();
                    if (!sizeof($aliases) === 0) {
                        /* @var $alias Alias */
                        $alias = $aliases[0];
                        $this->payload->getFrom()->setAlias($alias);
                    }
                }
            }
        }

        $this->logger = new Logger('Tokenio\User\StandingOrderTokenBuilder');
        $this->logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
    }

    /**
     * @param $accountId string
     * @return TransferTokenBuilder
     */
    public function setAccountId($accountId)
    {
        $token = new BankAccount\Token();
        $token->setAccountId($accountId);
        $token->setMemberId($this->member->getMemberId());

        /* @var $account BankAccount*/
        $account = new BankAccount();
        $account->setToken($token);
        if ($this->payload->getTransfer()->getInstructions() == null) {
            $this->payload->getTransfer()->setInstructions(new TransferInstructions());
        }
        $endPoint = new TransferEndpoint();
        $endPoint->setAccount($account);
        $this->payload->getTransfer()->getInstructions()->setSource($endPoint);
        return $this;
    }


    /**
     * @param $bankId
     * @param $authorization
     * @return TransferTokenBuilder
     */
    public function setCustomAuthorization($bankId, $authorization)
    {
        $bankAccount = new BankAccount();
        /** @var BankAccount\Custom $bankAccount */
        $customBankAccount = new BankAccount\Custom();
        $customBankAccount->setBankId($bankId)->setPayload($authorization);
        $bankAccount->setCustom($customBankAccount);

        $this->payload->getTransfer()->getInstructions()
            ->getSource()->setAccount($bankAccount);

        return $this;
    }

    /**
     * @param $expireAtMs int
     * @return TransferTokenBuilder
     */
    public function setExpireAtMs($expireAtMs)
    {
        $this->payload->setEffectiveAtMs($expireAtMs);
        return $this;
    }

    /**
     * @param $effectiveAtMs int
     * @return TransferTokenBuilder
     */
    public function setEffectiveAtMs($effectiveAtMs)
    {
        $this->payload->setEffectiveAtMs($effectiveAtMs);
        return $this;
    }

    /**
     * @param $endorseUntilMs int
     * @return TransferTokenBuilder
     */
    public function setEndorseUntilMs($endorseUntilMs)
    {
        $this->payload->setEndorseUntilMs($endorseUntilMs);
        return $this;
    }

    /**
     * @param $chargeAmount int
     * @return TransferTokenBuilder
     */
    public function setChargeAmount($chargeAmount)
    {
        $this->payload->getTransfer()->setAmount(strval($chargeAmount));
        return $this;
    }

    /**
     * @param $description string
     * @return TransferTokenBuilder
     */
    public function setDescription($description)
    {
        $this->payload->setDescription($description);
        return $this;
    }

    /**
     * @param $source TransferEndpoint
     * @return TransferTokenBuilder
     */
    public function setSource($source)
    {
        $this->payload->getTransfer()->getInstructions()->setSource($source);
        return $this;
    }

    /**
     * @param $transferDestination TransferDestination
     * @param $endPointDestination TransferEndpoint
     * @return TransferTokenBuilder
     */
    public function addDestination($transferDestination, $endPointDestination=null)
    {
        if($transferDestination !== null) {
            $this->payload->getTransfer()->getInstructions()->getTransferDestinations()[] = $transferDestination;
        }
        else {
            $this->payload->getTransfer()->getInstructions()->setDestinations([$endPointDestination]);
        }
        return $this;
    }

    /**
     * @param $toAlias Alias
     * @return TransferTokenBuilder
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
     * @return TransferTokenBuilder
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
     * @return TransferTokenBuilder
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
     * @return TransferTokenBuilder
     */
    public function setActingAs($actingAs)
    {
        $this->payload->setActingAs($actingAs);
        return $this;
    }

    /**
     * @param $tokenRequestID string
     * @return TransferTokenBuilder
     */
    public function setTokenRequestId($tokenRequestID)
    {
        $this->payload->setTokenRequestId($tokenRequestID);
        $this->tokenRequestId = $tokenRequestID;
        return $this;
    }

    /**
     * @param $receiptRequested boolean
     * @return TransferTokenBuilder
     */
    public function setReceiptRequested($receiptRequested)
    {
        $this->payload->setReceiptRequested($receiptRequested);
        return $this;
    }

    public function setProviderTransferMetadata($metadata)
    {
        $this->payload->getTransfer()->getInstructions()->getMetadata()
            ->setProviderTransferMetadata($metadata);
        return $this;
    }

    /**
     * @param $ultimateCreditor string
     * @return TransferTokenBuilder
     */
    public function setUltimateCreditor($ultimateCreditor)
    {
        $this->payload->getTransfer()
            ->getInstructions()
            ->getMetadata()
            ->setUltimateCreditor($ultimateCreditor);

        return $this;
    }

    /**
     * @param $ultimateDebtor string
     * @return TransferTokenBuilder
     */
    public function setUltimateDebtor($ultimateDebtor)
    {
        $this->payload->getTransfer()
            ->getInstructions()
            ->getMetadata()
            ->setUltimateDebtor($ultimateDebtor);
        return $this;
    }

    /**
     * @param $purposeCode string
     * @return TransferTokenBuilder
     */
    public function setPurposeCode($purposeCode)
    {
        $this->payload->getTransfer()
            ->getInstructions()
            ->getMetadata()
            ->setPurposeCode($purposeCode);
        return $this;
    }

    public function from($memberId)
    {
        $member = new TokenMember();
        $member->setId($memberId);
        $this->payload->setFrom($member);

        return $this;
    }

    public function buildPayload()
    {
        if(empty($this->payload->getRefId()))
        {
            $this->logger->warn("refId is not set. A random ID will be used.");
            $this->payload->setRefId(Strings::generateNonce());
        }
        return $this->payload;
    }

    /**
     * @return \Io\Token\Proto\Common\Token\Token|TransferTokenBuilder
     * @throws IllegalArgumentException
     * @throws \Exception
     */
    public function execute()
    {
        /* @var BankAccount $sourceCase */
        $sourceCase = $this->payload->getTransfer()->getInstructions()
            ->getSource()->getAccount();

        $caseList = array('TOKEN', 'BANK');
        if(!in_array($sourceCase, $caseList))
        {
            throw new IllegalArgumentException("No Sourceon token");
        }

        if($this->payload->getRefId() === null)
        {
            $this->logger->warn("refId is not set. A random ID will be used.");
            $this->payload->setRefId(Strings::generateNonce());
        }

        return $this->member->createTransferToken(null, $this->payload, null,null,$this->tokenRequestId != null ? $this->tokenRequestId : "");
    }

}