<?php


namespace Tokenio;


use Io\Token\Proto\Common\Providerspecific\ProviderTransferMetadata;
use Io\Token\Proto\Common\Token\TokenRequestPayload\TransferBody;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Io\Token\Proto\Common\Transferinstructions\TransferInstructions;
use Tokenio\TokenRequest\Builder\TokenRequestBuilder;

class TransferBuilder extends TokenRequestBuilder
{
    public function __construct($amount, $currency)
    {
        parent::__construct();
        $transferBody = new TransferBody();
        $transferBody->setLifetimeAmount($amount);
        $transferBody->setCurrency($currency);
        $this->requestPayload->setTransferBody($transferBody);
    }

    /**
     * Optional. Sets the source account to bypass account selection. May be required for
     * some banks.
     *
     * @param TransferEndpoint $source
     * @return TransferBuilder
     */
    public function setSource($source)
    {
        if ($this->requestPayload->getTransferBody()->getInstructions() == null) {
            $this->requestPayload->getTransferBody()->setInstructions(new TransferInstructions());
        }
        $this->requestPayload->getTransferBody()->getInstructions()->setSource($source);
        return $this;
    }

    /**
     * Optional. Sets the destination country in order to narrow down
     * the country selection in the web-app UI.
     *
     * @param string destinationCountry destination country
     * @return TransferBuilder
     */
    public function setDestinationCountry($destinationCountry)
    {
        $this->requestPayload->setDestinationCountry($destinationCountry);
        return $this;
    }

    /**
     * Adds a transfer destination to a transfer token request.
     *
     * NOTE: Should use TransferDestination. Support for TransferEndpoint will be removed.
     *
     * @param TransferDestination destination
     * @return TransferBuilder
     */
    public function addDestination($destination)
    {
        if ($destination instanceof TransferDestination) {
            if ($this->requestPayload->getTransferBody()->getInstructions() == null) {
                $this->requestPayload->getTransferBody()->setInstructions(new TransferInstructions());
            }
            $this->requestPayload->getTransferBody()->getInstructions()->getTransferDestinations()[] = $destination;
        } else {
            $this->requestPayload->getTransferBody()->getDestinations()[] = $destination;
        }
        return $this;
    }

    /**
     * Sets the maximum amount per charge on a transfer token request.
     *
     * @param string chargeAmount
     * @return TransferBuilder
     */
    public function setChargeAmount($chargeAmount)
    {
        $this->requestPayload->getTransferBody()->setAmount($chargeAmount);
        return $this;
    }

    /**
     * Optional. Adds metadata for a specific provider.
     *
     * @param ProviderTransferMetadata $metadata provider-specific metadata
     * @return TransferBuilder
     */
    public function setProviderTransferMetadata($metadata)
    {
        if ($this->requestPayload->getTransferBody()->getInstructions() == null) {
            $this->requestPayload->getTransferBody()->setInstructions(new TransferInstructions());
        }
        if ($this->requestPayload->getTransferBody()->getInstructions()->getMetadata() == null) {
            $this->requestPayload->getTransferBody()->getInstructions()->setMetadata(new TransferInstructions\Metadata());
        }

        $this->requestPayload->getTransferBody()->getInstructions()->getMetadata()->setProviderTransferMetadata($metadata);
        return $this;
    }

    /**
     * Optional. Set the bearer for any Foreign Exchange fees incurred on the transfer.
     *
     * @param int $chargeBearer Bearer of the charges for any Fees related to the transfer.
     * @return TransferBuilder
     */
    public function setChargeBearer($chargeBearer)
    {
        if ($this->requestPayload->getTransferBody()->getInstructions() == null) {
            $this->requestPayload->getTransferBody()->setInstructions(new TransferInstructions());
        }
        if ($this->requestPayload->getTransferBody()->getInstructions()->getMetadata() == null) {
            $this->requestPayload->getTransferBody()->getInstructions()->setMetadata(new TransferInstructions\Metadata());
        }
        $this->requestPayload->getTransferBody()->getInstructions()->getMetadata()->setChargeBearer($chargeBearer);
        return $this;
    }

    /**
     * Optional. Sets the ultimate party to which the money is due.
     *
     * @param string $ultimateCreditor
     * @return TransferBuilder
     */
    public function setUltimateCreditor($ultimateCreditor)
    {
        if ($this->requestPayload->getTransferBody()->getInstructions() == null) {
            $this->requestPayload->getTransferBody()->setInstructions(new TransferInstructions());
        }
        if ($this->requestPayload->getTransferBody()->getInstructions()->getMetadata() == null) {
            $this->requestPayload->getTransferBody()->getInstructions()->setMetadata(new TransferInstructions\Metadata());
        }

        $this->requestPayload->getTransferBody()->getInstructions()->getMetadata()->setUltimateCreditor($ultimateCreditor);
        return $this;
    }

    /**
     * Optional. Sets ultimate party that owes the money to the (ultimate) creditor.
     *
     * @param string $ultimateDebtor
     * @return TransferBuilder
     */
    public function setUltimateDebtor($ultimateDebtor)
    {
        if ($this->requestPayload->getTransferBody()->getInstructions() == null) {
            $this->requestPayload->getTransferBody()->setInstructions(new TransferInstructions());
        }
        if ($this->requestPayload->getTransferBody()->getInstructions()->getMetadata() == null) {
            $this->requestPayload->getTransferBody()->getInstructions()->setMetadata(new TransferInstructions\Metadata());
        }

        $this->requestPayload->getTransferBody()->getInstructions()->getMetadata()->setUltimateCreditor($ultimateDebtor);
        return $this;
    }

    /**
     * Optional. Sets the purpose code. Refer to ISO 20022 external code sets.
     *
     * @param string $purposeCode
     * @return TransferBuilder
     */
    public function setPurposeCode($purposeCode)
    {
        if ($this->requestPayload->getTransferBody()->getInstructions() == null) {
            $this->requestPayload->getTransferBody()->setInstructions(new TransferInstructions());
        }
        if ($this->requestPayload->getTransferBody()->getInstructions()->getMetadata() == null) {
            $this->requestPayload->getTransferBody()->getInstructions()->setMetadata(new TransferInstructions\Metadata());
        }

        $this->requestPayload->getTransferBody()->getInstructions()->getMetadata()->setPurposeCode($purposeCode);
        return $this;
    }

}
