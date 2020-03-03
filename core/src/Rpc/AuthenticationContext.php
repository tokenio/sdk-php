<?php

namespace Tokenio\Rpc;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Security\CustomerTrackingMetadata;

class AuthenticationContext
{
    /**
     * @var string
     */
    private $onBehalfOf;

    /**
     * @var int
     */
    private $keyLevel;

    /**
     * @var bool
     */
    private $customerInitiated;

    /**
     * @var CustomerTrackingMetadata
     */
    private $customerTrackingMetadata;

    public function __construct(
        $onBehalfOf = null,
        $customerInitiated,
        $keyLevel,
        $customerTrackingMetadata)
    {
        $this->onBehalfOf = $onBehalfOf;
        $this->keyLevel = $keyLevel;
        $this->customerInitiated = $customerInitiated;
        $this->customerTrackingMetadata = $customerTrackingMetadata;
    }

    /**
     * Retrieves the On-Behalf-Of value.
     *
     * @return string the current On-Behalf-Of value
     */
    public function getOnBehalfOf()
    {
        return $this->onBehalfOf;
    }

    /**
     * Retrieves the Key-Level value.
     *
     * @return int the current Key-Level value
     */
    public function getKeyLevel()
    {
        if ($this->keyLevel == null) {
            return Level::LOW;
        }
        return $this->keyLevel;
    }

    /**
     * Get the customer initiated request flag.
     *
     * @return bool
     */
    public function getCustomerInitiated()
    {
        if ($this->customerInitiated == null) {
            return false;
        }

        return $this->customerInitiated;
    }

    /**
     * Resets the authenticator.
     */
    public function clear()
    {
        $this->onBehalfOf = null;
        $this->customerInitiated = null;
    }

    public function getCustomerTrackingMetadata()
    {
        if ($this->customerTrackingMetadata == null) {
            return new CustomerTrackingMetadata();
        }
        return $this->customerTrackingMetadata;
    }
}
