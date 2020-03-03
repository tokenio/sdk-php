<?php

namespace Tokenio\Tpp\TokenRequest;

use Google\Protobuf\Internal\Message;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\AccessBody\Resource\TransferDestinations;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Tokenio\Tpp\Exception\InvalidTokenRequestQuery;

class TokenRequestTransferDestinationsCallbackParameters
{
    const COUNTRY_FIELD = 'country';
    const BANK_NAME_FIELD = 'bankName';
    const SUPPORTED_TRANSFER_DESTINATION_TYPES_FIELD = 'supportedTransferDestinationType';

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $bankName;

    /**
     * @var TransferDestination[]
     */
    private $supportedTransferDestinationTypes;

    /**
     * @param $parameters
     * @return TokenRequestTransferDestinationsCallbackParameters
     */
    public static function create($parameters)
    {
        if (!isset($parameters[self::COUNTRY_FIELD], $parameters[self::BANK_NAME_FIELD], $parameters[self::SUPPORTED_TRANSFER_DESTINATION_TYPES_FIELD])) {
            throw new InvalidTokenRequestQuery();
        }

        /** @var TransferDestination[] $transferDestination */
        $transferDestination = $parameters[self::SUPPORTED_TRANSFER_DESTINATION_TYPES_FIELD];
        return new TokenRequestTransferDestinationsCallbackParameters($parameters[self::COUNTRY_FIELD], $parameters[self::BANK_NAME_FIELD], $transferDestination);
    }

    private function __construct($country, $bankName, $supportedTransferDestinationTypes)
    {
        $this->country = $country;
        $this->bankName = $bankName;
        $this->supportedTransferDestinationTypes = $supportedTransferDestinationTypes;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @return
     * TransferDestination[]
     */
    public function getSupportedTransferDestinationTypes()
    {
        return $this->supportedTransferDestinationTypes;
    }
}
