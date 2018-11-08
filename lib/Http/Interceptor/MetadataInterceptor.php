<?php
/** @noinspection PhpOptionalBeforeRequiredParametersInspection */

namespace Tokenio\Http\Interceptor;

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
                                        array $metadata = [],
                                        array $options = [],
                                        $continuation)
    {
        $metadata = array_merge($metadata, $this->metadata);
        return parent::interceptUnaryUnary($method, $argument, $deserialize, $metadata, $options, $continuation);
    }
}