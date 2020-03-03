<?php

namespace Tokenio\Rpc\Interceptor;

use Grpc\Interceptor;

class TimeoutInterceptor extends Interceptor
{
    /**
     * @var int
     */
    private $timeout;

    /**
     * Construct the TimeoutInterceptor.
     *
     * @param int $timeout
     */
    public function __construct($timeout)
    {
        $this->timeout = $timeout;
    }

    public function interceptUnaryUnary($method,
                                        $argument,
                                        $deserialize,
                                        array $metadata = [],
                                        array $options = [],
                                        $continuation)
    {
        $options['timeout'] = ($this->timeout * 1000);
        return parent::interceptUnaryUnary($method, $argument, $deserialize, $metadata, $options, $continuation);
    }
}
