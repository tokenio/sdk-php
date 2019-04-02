<?php
/**
 * Created by PhpStorm.
 * User: prateek
 * Date: 2019-04-01
 * Time: 14:57
 */

namespace Tokenio\Exception;


use Throwable;

class BankAuthorizationRequiredException extends \RuntimeException
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}