<?php


namespace Tokenio\User;

use Io\Token\Proto\Common\Account\BankAccount;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Token\ActingAs;
use Io\Token\Proto\Common\Token\BulkTransferBody;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequest;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Tokenio\Exception\IllegalArgumentException;
use Tokenio\Util\Strings;

class BulkTransferTokenBuilder
{
    const REF_ID_MAX_LENGTH = 18;

    /* @var TokenPayload $payload */
    private $payload;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * BulkTransferTokenBuilder constructor.
     * @param $tokenRequest TokenRequest
     * @param $member Member
     * @param $transfers BulkTransferBody\Transfer[]
     * @param $totalAmount double
     * @param $source TransferEndpoint
     * @throws \Exception
     */
    public function __construct($tokenRequest, $member=null, $transfers= null, $totalAmount= null, $source= null)
    {

        if($tokenRequest === null) {
            $newMember = new TokenMember();
            $newMember->setId($member->getMemberId());

            $bulkTransfer = new BulkTransferBody();
            $bulkTransfer->setTransfers($transfers)
                ->setTotalAmount(strval($totalAmount))
                ->setSource($source);

            $this->payload = new TokenPayload();
            $this->payload->setVersion("1.0")
                ->setFrom($newMember)
                ->setBulkTransfer($bulkTransfer);

            /** @var Alias[] $aliases */
            $aliases = $member->aliases();
            if (!empty($aliases)) {
                $this->payload->getFrom()->setAlias($aliases[0]);
            }
        }
        else
        {
            if($tokenRequest->getRequestPayload()->getRequestBody() !== "BULK_TRANSFER_BODY")
            {
                throw new IllegalArgumentException("No payee on token request");
            }
            if(! $tokenRequest->getRequestPayload()->getTo() === null)
            {
                throw new IllegalArgumentException("No payee on token request");
            }
            $body = $tokenRequest->getRequestPayload()->getBulkTransferBody();
            $this->payload = new TokenPayload();
            $this->payload->setVersion("1.0")
                ->setRefId($tokenRequest->getRequestPayload()->getRefId())
                ->setFrom($tokenRequest->getRequestOptions()->getFrom())
                ->setTo($tokenRequest->getRequestPayload()->getTo())
                ->setDescription($tokenRequest->getRequestPayload()->getDescription())
                ->setReceiptRequested($tokenRequest->getRequestOptions()->getReceiptRequested())
                ->setTokenRequestId($tokenRequest->getId())
                ->setBulkTransfer($body);

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
     * @return BulkTransferTokenBuilder
     */
    public function setExpireAtMs($expireAtMs)
    {
        $this->payload->setEffectiveAtMs($expireAtMs);
        return $this;
    }

    /**
     * @param $effectiveAtMs int
     * @return BulkTransferTokenBuilder
     */
    public function setEffectiveAtMs($effectiveAtMs)
    {
        $this->payload->setEffectiveAtMs($effectiveAtMs);
        return $this;
    }

    /**
     * @param $endorseUntilMs int
     * @return BulkTransferTokenBuilder
     */
    public function setEndorseUntilMs($endorseUntilMs)
    {
        $this->payload->setEndorseUntilMs($endorseUntilMs);
        return $this;
    }

    /**
     * @param $description string
     * @return BulkTransferTokenBuilder
     */
    public function setDescription($description)
    {
        $this->payload->setDescription($description);
        return $this;
    }

    /**
     * @param $source TransferEndpoint
     * @return BulkTransferTokenBuilder
     */
    public function setSource($source)
    {
        $this->payload->getStandingOrder()->getInstructions()->setSource($source);
        return $this;
    }

    /**
     * @param $accountId string
     * @return BulkTransferTokenBuilder
     */
    public function setAccountId($accountId)
    {
        ExceptionInAssertPreConditionsTest::assertEmpty(!$this->payload->getFrom()->getId());
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
     * @param $toAlias Alias
     * @return BulkTransferTokenBuilder
     */
    public function setToAlias($toAlias)
    {
        $this->payload->getTo()->setAlias($toAlias);
        return $this;
    }

    /**
     * @param $toMemberId string
     * @return BulkTransferTokenBuilder
     */
    public function setToMemberId($toMemberId)
    {
        $this->payload->getTo()->setId($toMemberId);
        return $this;
    }

    /**
     * @param $refId string
     * @return BulkTransferTokenBuilder
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
     * @return BulkTransferTokenBuilder
     */
    public function setActingAs($actingAs)
    {
        $this->payload->setActingAs($actingAs);
        return $this;
    }

    /**
     * @param $tokenRequestID string
     * @return BulkTransferTokenBuilder
     */
    public function setTokenRequestId($tokenRequestID)
    {
        $this->payload->setTokenRequestId($tokenRequestID);
        return $this;
    }

    /**
     * @param $receiptRequested boolean
     * @return BulkTransferTokenBuilder
     */
    public function setReceiptRequested($receiptRequested)
    {
        $this->payload->setReceiptRequested($receiptRequested);
        return $this;
    }


    /**
     * @return TokenPayload
     */
    public function buildPayload()
    {
        if(isEmpty($this->payload->getRefId()))
        {
            $this->logger->warn("refId is not set. A random ID will be used.");
            $this->payload->setRefId(Strings::generateNonce());
        }
        return $this->payload;
    }
}