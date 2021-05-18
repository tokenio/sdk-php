<?php
/** @noinspection PhpOptionalBeforeRequiredParametersInspection */

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
	                                    $continuation,
                                        array $metadata = [],
                                        array $options = [])
    {
        $options['timeout'] = ($this->timeout * 1000);
        return parent::interceptUnaryUnary($method, $argument, $deserialize, $continuation, $metadata, $options);
    }
}
