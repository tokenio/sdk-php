<?php


namespace Tokenio\TokenRequest\Builder;


use Io\Token\Proto\Common\Providerspecific\ProviderTransferMetadata;
use Io\Token\Proto\Common\Token\StandingOrderBody;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Io\Token\Proto\Common\Transferinstructions\TransferInstructions;

class StandingOrderBuilder extends TokenRequestBuilder
{
    public function __construct(
        $amount = null,
        $currency = null,
        $frequency = null,
        $startDate = null,
        $endDate = null,
        $destinations = null)
    {
        parent::__construct();
        $standingOrderBody = new StandingOrderBody();
        $standingOrderBody->setAmount($amount);
        $standingOrderBody->setCurrency($currency);
        $standingOrderBody->setFrequency($frequency);
        $standingOrderBody->setStartDate($startDate);
        $standingOrderBody->setEndDate($endDate);

        $instructions = new TransferInstructions();
        $instructions->setDestinations($destinations);
        $standingOrderBody->setInstructions($instructions);
        $this->requestPayload->setStandingOrderBody($standingOrderBody);
    }

    /**
     * Sets the amount per charge of the standing order.
     *
     * @param double $amount amount per individual charge
     * @return StandingOrderBuilder
     */
    public function setAmount($amount)
    {
        $this->requestPayload->getStandingOrderBody()->setAmount($amount);
        return $this;
    }

    /**
     * Sets the currency for each charge in the standing order.
     *
     * @param string $currency
     * @return StandingOrderBuilder
     */
    public function setCurrency($currency)
    {
        $this->requestPayload->getStandingOrderBody()->setCurrency($currency);
        return $this;
    }

    /**
     * Sets the frequency of the standing order. ISO 20022: DAIL, WEEK, TOWK,
     * MNTH, TOMN, QUTR, SEMI, YEAR
     *
     * @param string $frequency
     * @return StandingOrderBuilder
     */
    public function setFrequency($frequency)
    {
        $this->requestPayload->getStandingOrderBody()->setFrequency($frequency);
        return $this;
    }

    /**
     * Sets the start date of the standing order. ISO 8601: YYYY-MM-DD or YYYYMMDD.
     *
     * @param string $startDate
     * @return StandingOrderBuilder
     */
    public function setStartDate($startDate)
    {
        $this->requestPayload->getStandingOrderBody()->setStartDate($startDate);
        return $this;
    }

    /**
     * Sets the end date of the standing order. ISO 8601: YYYY-MM-DD or YYYYMMDD.
     * If not specified, the standing order will occur indefinitely.
     *
     * @param string $endDate
     * @return StandingOrderBuilder
     */
    public function setEndDate($endDate)
    {
        $this->requestPayload->getStandingOrderBody()->setEndDate($endDate);
        return $this;
    }

    /**
     * Adds a destination account to a standing order token request.
     *
     * @param TransferDestination $destination
     * @return StandingOrderBuilder
     */
    public function addDestination($destination)
    {
        if ($this->requestPayload->getStandingOrderBody()->getInstructions() == null) {
            $this->requestPayload->getStandingOrderBody()->setInstructions(new TransferInstructions());
        }
        $this->requestPayload->getStandingOrderBody()->getInstructions()->getTransferDestinations()[] = $destination;
        return $this;
    }

    /**
     * Optional. Sets the destination country in order to narrow down
     * the country selection in the web-app UI.
     *
     * @param string destinationCountry destination country
     * @return StandingOrderBuilder
     */
    public function setDestinationCountry($destinationCountry)
    {
        $this->requestPayload->setDestinationCountry($destinationCountry);
        return $this;
    }

    /**
     * Optional. Sets the source account to bypass account selection.
     *
     * @param string source source account
     * @return StandingOrderBuilder
     */
    public function setSource($source)
    {
        if ($this->requestPayload->getStandingOrderBody()->getInstructions() == null) {
            $this->requestPayload->getStandingOrderBody()->setInstructions(new TransferInstructions());
        }
        
        $this->requestPayload->getStandingOrderBody()->getInstructions()->setSource($source);
        return $this;
    }

    /**
     * Optional. Adds metadata for a specific provider.
     *
     * @param $metadata ProviderTransferMetadata provider-specific metadata
     * @return StandingOrderBuilder
     */
    public function setProviderTransferMetadata($metadata)
    {
        if ($this->requestPayload->getStandingOrderBody()->getInstructions() == null) {
            $this->requestPayload->getStandingOrderBody()->setInstructions(new TransferInstructions());
        }
        if ($this->requestPayload->getStandingOrderBody()->getInstructions()->getMetadata() == null) {
            $this->requestPayload->getStandingOrderBody()->getInstructions()->setMetadata(new TransferInstructions\Metadata());
        }

        $this->requestPayload->getStandingOrderBody()
            ->getInstructions()
            ->getMetadata()
            ->setProviderTransferMetadata($metadata);

        return $this;
    }

    /**
     * Optional. Sets the ultimate party to which the money is due.
     *
     * @param string $ultimateCreditor the ultimate creditor
     * @return StandingOrderBuilder
     */
    public function setUltimateCreditor($ultimateCreditor)
    {
        if ($this->requestPayload->getStandingOrderBody()->getInstructions() == null) {
            $this->requestPayload->getStandingOrderBody()->setInstructions(new TransferInstructions());
        }
        if ($this->requestPayload->getStandingOrderBody()->getInstructions()->getMetadata() == null) {
            $this->requestPayload->getStandingOrderBody()->getInstructions()->setMetadata(new TransferInstructions\Metadata());
        }

        $this->requestPayload->getStandingOrderBody()->getInstructions()->getMetadata()->setUltimateCreditor($ultimateCreditor);
        return $this;
    }

    /**
     * Optional. Sets ultimate party that owes the money to the (ultimate) creditor.
     *
     * @param string $ultimateDebtor the ultimate debtor
     * @return StandingOrderBuilder
     */
    public function setUltimateDebtor($ultimateDebtor)
    {
        if ($this->requestPayload->getStandingOrderBody()->getInstructions() == null) {
            $this->requestPayload->getStandingOrderBody()->setInstructions(new TransferInstructions());
        }
        if ($this->requestPayload->getStandingOrderBody()->getInstructions()->getMetadata() == null) {
            $this->requestPayload->getStandingOrderBody()->getInstructions()->setMetadata(new TransferInstructions\Metadata());
        }

        $this->requestPayload->getStandingOrderBody()->getInstructions()->getMetadata()->setUltimateCreditor($ultimateDebtor);
        return $this;
    }

    /**
     * Optional. Sets the purpose code. Refer to ISO 20022 external code sets.
     *
     * @param string $purposeCode the purpose code
     * @return StandingOrderBuilder
     */
    public function setPurposeCode($purposeCode)
    {
        if ($this->requestPayload->getStandingOrderBody()->getInstructions() == null) {
            $this->requestPayload->getStandingOrderBody()->setInstructions(new TransferInstructions());
        }
        if ($this->requestPayload->getStandingOrderBody()->getInstructions()->getMetadata() == null) {
            $this->requestPayload->getStandingOrderBody()->getInstructions()->setMetadata(new TransferInstructions\Metadata());
        }
        $this->requestPayload->getStandingOrderBody()->getInstructions()->getMetadata()->setPurposeCode($purposeCode);
        return $this;
    }
}
