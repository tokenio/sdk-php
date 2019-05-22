<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: account.proto

namespace Io\Token\Proto\Common\Account\BankAccount;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.account.BankAccount.Iban</code>
 */
class Iban extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional
     *
     * Generated from protobuf field <code>string bic = 1;</code>
     */
    private $bic = '';
    /**
     * Generated from protobuf field <code>string iban = 2;</code>
     */
    private $iban = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $bic
     *           Optional
     *     @type string $iban
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Account::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional
     *
     * Generated from protobuf field <code>string bic = 1;</code>
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * Optional
     *
     * Generated from protobuf field <code>string bic = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setBic($var)
    {
        GPBUtil::checkString($var, True);
        $this->bic = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string iban = 2;</code>
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Generated from protobuf field <code>string iban = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setIban($var)
    {
        GPBUtil::checkString($var, True);
        $this->iban = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Iban::class, \Io\Token\Proto\Common\Account\BankAccount_Iban::class);

