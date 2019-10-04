<?php


namespace Tokenio;


use Io\Token\Proto\Common\Token\TokenRequestPayload\TransferBody;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Io\Token\Proto\Common\Transferinstructions\TransferInstructions;

class TransferTokenRequestBuilder extends TokenRequestBuilder
{
    public function __construct($amount, $currency)
    {
        parent::__construct(null);
        $transferBody = new TransferBody();
        $transferBody->setLifetimeAmount($amount);
        $transferBody->setCurrency($currency);
        $this->requestPayload->setTransferBody($transferBody);
    }

    /**
     * Optional. Sets the destination country in order to narrow down
     * the country selection in the web-app UI.
     *
     * @param string destinationCountry destination country
     * @return TransferTokenRequestBuilder
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
     * @return TransferTokenRequestBuilder
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
     * @return TransferTokenRequestBuilder
     */
    public function setChargeAmount($chargeAmount)
    {
        $this->requestPayload->getTransferBody()->setAmount($chargeAmount);
        return $this;
    }

    /**
     * Sets the execution date of the transfer. Used for future-dated payments.
     * Uses ISO 8601 format: YYYY-MM-DD.
     *
     * @param string $executionDate execution date
     * @return TransferTokenRequestBuilder
     */
    public function setExecutionDate($executionDate)
    {
        $this->requestPayload->getTransferBody()->setExecutionDate($executionDate);
        return $this;
    }
}
