<?php


namespace Tokenio;


use Io\Token\Proto\Common\Providerspecific\ProviderTransferMetadata;
use Io\Token\Proto\Common\Token\StandingOrderBody;
use Io\Token\Proto\Common\Transferinstructions\TransferInstructions;

class StandingOrderTokenRequestBuilder extends TokenRequestBuilder
{
    public function __construct(
        $amount,
        $currency,
        $frequency,
        $startDate,
        $endDate,
        $destinations)
    {
        parent::__construct(null);
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
     * Optional. Sets the destination country in order to narrow down
     * the country selection in the web-app UI.
     *
     * @param string destinationCountry destination country
     * @return StandingOrderTokenRequestBuilder
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
     * @return StandingOrderTokenRequestBuilder
     */
    public function setSource($source)
    {
        $this->requestPayload->getBulkTransferBody()->setSource($source);
        return $this;
    }

    /**
     * Optional. Adds metadata for a specific provider.
     *
     * @param $metadata ProviderTransferMetadata provider-specific metadata
     * @return StandingOrderTokenRequestBuilder
     */
    public function setProviderTransferMetadata($metadata)
    {
        $this->requestPayload->getTransferBody()
            ->getInstructions()
            ->getMetadata()
            ->setProviderTransferMetadata($metadata);
        return $this;
    }
}
