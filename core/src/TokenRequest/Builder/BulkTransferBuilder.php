<?php

namespace Tokenio\TokenRequest\Builder;

use Io\Token\Proto\Common\Token\BulkTransferBody;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;

class BulkTransferBuilder extends TokenRequestBuilder
{
    /**
     * BulkTransferBuilder constructor.
     * @param BulkTransferBody\Transfer[] $transfers
     * @param $totalAmount
     */
    public function __construct($transfers, $totalAmount)
    {
        parent::__construct();
        $bulkTransferBody = new BulkTransferBody();
        $bulkTransferBody->setTransfers($transfers);
        $bulkTransferBody->setTotalAmount($totalAmount);

        $this->requestPayload->setBulkTransferBody($bulkTransferBody);
    }

    /**
     * Optional. Sets the source account to bypass account selection.
     *
     * @param TransferEndpoint $source
     * @return BulkTransferBuilder
     */
    public function setSource($source)
    {
        $this->requestPayload->getBulkTransferBody()->setSource($source);
        return $this;
    }
}