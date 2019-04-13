<?php

namespace Tokenio;

use Io\Token\Proto\Common\Account\BankAccount;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Blob\Attachment;
use Io\Token\Proto\Common\Blob\Blob\Payload;
use Io\Token\Proto\Common\Pricing\Pricing;
use Io\Token\Proto\Common\Token\ActingAs;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TransferBody;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Io\Token\Proto\Common\Transferinstructions\TransferInstructions;
use Tokenio\Exception\IllegalArgumentException;
use Tokenio\Util\Strings;

class TransferTokenBuilder
{
    /**
     * @var Member
     */
    private $member;

    /**
     * @var TokenPayload
     */
    private $payload;

    /**
     * @var Payload[]
     */
    private $blobPayloads;

    /**
     * Creates the builder object.
     *
     * @param Member $member the payer of the token
     * @param double $amount the lifetime amount of the token
     * @param string $currency the currency of the token
     */
    public function __construct($member, $amount, $currency)
    {
        $this->member = $member;

        $this->payload = new TokenPayload();
        $this->payload->setVersion('1.0');

        $fromTokenMember = new TokenMember();
        $fromTokenMember->setId($member->getMemberId());
        $this->payload->setFrom($fromTokenMember);
        $this->payload->setTo(new TokenMember());

        $instructions = new TransferInstructions();
        $instructions->setSource(new TransferEndpoint());
        $instructions->setMetadata(new TransferInstructions\Metadata());

        $transferBody = new TransferBody();
        $transferBody->setCurrency($currency);
        $transferBody->setLifetimeAmount(strval($amount));
        $transferBody->setInstructions($instructions);
        $transferBody->setRedeemer(new TokenMember());

        $this->payload->setTransfer($transferBody);

        $alias = $member->getFirstAlias();
        if ($alias != null) {
            $this->payload->getFrom()->setAlias($alias);
        }

        $this->blobPayloads = array();
    }

    /**
     * Adds a source accountId to the token.
     *
     * @param string $accountId the source accountId
     * @return TransferTokenBuilder
     */
    public function setAccountId($accountId)
    {
        $token = new BankAccount\Token();
        $token->setAccountId($accountId);
        $token->setMemberId($this->member->getMemberId());

        $sourceAccount = new BankAccount();
        $sourceAccount->setToken($token);

        $this->payload->getTransfer()->getInstructions()->getSource()->setAccount($sourceAccount);

        return $this;
    }

    /**
     * Sets the source custom authorization.
     *
     * @param string $bankId source bank ID
     * @param string $authorization source custom authorization
     * @return TransferTokenBuilder
     */
    public function setCustomAuthorization($bankId, $authorization)
    {
        $custom = new BankAccount\Custom();
        $custom->setBankId($bankId);
        $custom->setPayload($authorization);

        $sourceAccount = new BankAccount();
        $sourceAccount->setCustom($custom);

        $this->payload->getTransfer()->getInstructions()->getSource()->setAccount($sourceAccount);

        return $this;
    }

    /**
     * Sets the expiration date.
     *
     * @param int $expiresAtMs the expiration date in ms.
     * @return TransferTokenBuilder
     */
    public function setExpiresAtMs($expiresAtMs)
    {
        $this->payload->setExpiresAtMs($expiresAtMs);
        return $this;
    }

    /**
     * Sets the effective date.
     *
     * @param int $effectiveAtMs the effective date in ms.
     * @return TransferTokenBuilder
     */
    public function setEffectiveAtMs($effectiveAtMs)
    {
        $this->payload->setEffectiveAtMs($effectiveAtMs);
        return $this;
    }

    /**
     * Sets the time after which endorse is no longer possible.
     *
     * @param int $endorseUntilMs endorse until, in milliseconds.
     * @return TransferTokenBuilder
     */
    public function setEndorseUntilMs($endorseUntilMs)
    {
        $this->payload->setEndorseUntilMs($endorseUntilMs);
        return $this;
    }

    /**
     * Sets the maximum amount per charge.
     *
     * @param double $chargeAmount the charge amount
     * @return TransferTokenBuilder
     */
    public function setChargeAmount($chargeAmount)
    {
        $this->payload->getTransfer()->setAmount(strval($chargeAmount));
        return $this;
    }

    /**
     * Sets the description.
     *
     * @param string $description the description
     * @return TransferTokenBuilder
     */
    public function setDescription($description)
    {
        $this->payload->setDescription($description);
        return $this;
    }

    /**
     * Adds a transfer source.
     *
     * @param TransferEndpoint $source
     * @return TransferTokenBuilder
     */
    public function setSource($source)
    {
        $this->payload->getTransfer()->getInstructions()->setSource($source);
        return $this;
    }

    /**
     * Adds a transfer destination.
     *
     * @param TransferEndpoint $destination the destination
     * @return TransferTokenBuilder
     */
    public function addDestination($destination)
    {
        $destinations = $this->payload->getTransfer()->getInstructions()->getDestinations();
        $destinations[] = $destination;

        $this->payload->getTransfer()->getInstructions()->setDestinations($destinations);

        return $this;
    }

    /**
     * Adds an attachment to the token.
     *
     * @param Attachment $attachment the attachment
     * @return TransferTokenBuilder
     */
    public function addAttachment($attachment)
    {
        $attachments = $this->payload->getTransfer()->getAttachments();
        $attachments[] = $attachment;

        $this->payload->getTransfer()->setAttachments($attachments);

        return $this;
    }

    /**
     * Adds an attachment by filename (reads file, uploads it, and attaches it).
     *
     * @param string $ownerId the owner id
     * @param string $type the MIME type of file
     * @param string $name the name of the file
     * @param string $data file binary data
     * @return TransferTokenBuilder
     */
    public function addAttachmentByFilename($ownerId, $type, $name, $data)
    {
        $payload = new Payload();
        $payload->setOwnerId($ownerId);
        $payload->setType($type);
        $payload->setName($name);
        $payload->setData($data);

        $this->blobPayloads[] = $payload;

        return $this;
    }

    /**
     * Sets the alias of the payee.
     *
     * @param Alias $toAlias the alias
     * @return TransferTokenBuilder
     */
    public function setToAlias($toAlias)
    {
        $this->payload->getTo()->setAlias($toAlias);
        return $this;
    }

    /**
     * Sets the member Id of the payee.
     *
     * @param string $toMemberId the member id
     * @return TransferTokenBuilder
     */
    public function setToMemberId($toMemberId)
    {
        $this->payload->getTo()->setId($toMemberId);
        return $this;
    }

    /**
     * Sets the reference Id of the token.
     *
     * @param string $refId
     * @return TransferTokenBuilder
     * @throws IllegalArgumentException
     */
    public function setRefId($refId)
    {
        if (strlen($refId) > 18) {
            throw new IllegalArgumentException('The length of the refId is at most 18, got: ' . strlen($refId));
        }

        $this->payload->setRefId($refId);
        return $this;
    }

    /**
     * Sets the pricing (fees/fx) on the token.
     *
     * @param Pricing $pricing the pricing
     * @return TransferTokenBuilder
     */
    public function setPricing($pricing)
    {
        $this->payload->getTransfer()->setPricing($pricing);
        return $this;
    }

    /**
     * Sets the purpose of payment.
     *
     * @param int $purposeOfPayment the purpose of payment
     * @return TransferTokenBuilder
     */
    public function setPurposeOfPayment($purposeOfPayment)
    {
        $this->payload->getTransfer()->getInstructions()->getMetadata()->setTransferPurpose($purposeOfPayment);
        return $this;
    }

    /**
     * Sets acting as on the token
     *
     * @param ActingAs $actingAs entity the redeemer is acting on behalf of
     * @return TransferTokenBuilder
     */
    public function setActingAs($actingAs)
    {
        $this->payload->setActingAs($actingAs);
        return $this;
    }

    /**
     * Builds a token payload, without uploading blobs or attachments.
     *
     * @return TokenPayload the token payload
     * @throws IllegalArgumentException
     */
    public function build()
    {
        $to = $this->payload->getTo();
        if ($to->getId() == null && $to->getAlias() == null) {
            throw new IllegalArgumentException('No payee on token request');
        }

        return $this->payload;
    }
}
