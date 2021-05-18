<?php
/** @noinspection PhpOptionalBeforeRequiredParametersInspection */

namespace Tokenio\Rpc\Interceptor;

use Grpc\Interceptor;

class MetadataInterceptor extends Interceptor
{
    private $metadata;

    /**
     * Construct the MetadataInterceptor.
     * @param array $metadata
     */
    public function __construct($metadata)
    {
        $this->metadata = $metadata;
    }

    public function interceptUnaryUnary($method,
                                        $argument,
                                        $deserialize,
	                                    $continuation,
                                        array $metadata = [],
                                        array $options = [])
    {
        $metadata = array_merge($metadata, $this->metadata);
        return parent::interceptUnaryUnary($method, $argument, $deserialize, $continuation, $metadata, $options);
    }
}
