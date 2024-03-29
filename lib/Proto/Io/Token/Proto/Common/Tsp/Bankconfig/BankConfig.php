<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: tsp/bankconfig.proto

namespace Io\Token\Proto\Common\Tsp\Bankconfig;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.tsp.bankconfig.BankConfig</code>
 */
class BankConfig extends \Google\Protobuf\Internal\Message
{
    protected $config;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\UKOpenBankingStandard $uk_open_banking_standard
     *     @type \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\NextGenPsd2Standard $next_gen_psd2_standard
     *     @type \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\PolishApiStandard $polish_api_standard
     *     @type \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\ProviderSampleStandard $provider_sample_standard
     *     @type \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\StetPsd2Standard $stet_psd2_standard
     *     @type \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\StarlingApiStandard $starling_api_standard
     *     @type \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\CzechPsd2Standard $czech_psd2_standard
     *     @type \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\BudapestPsd2Standard $budapest_psd2_standard
     *     @type \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\SlovakPsd2Standard $slovak_psd2_standard
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Tsp\Bankconfig::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.UKOpenBankingStandard uk_open_banking_standard = 1;</code>
     * @return \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\UKOpenBankingStandard
     */
    public function getUkOpenBankingStandard()
    {
        return $this->readOneof(1);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.UKOpenBankingStandard uk_open_banking_standard = 1;</code>
     * @param \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\UKOpenBankingStandard $var
     * @return $this
     */
    public function setUkOpenBankingStandard($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_UKOpenBankingStandard::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.NextGenPsd2Standard next_gen_psd2_standard = 2;</code>
     * @return \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\NextGenPsd2Standard
     */
    public function getNextGenPsd2Standard()
    {
        return $this->readOneof(2);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.NextGenPsd2Standard next_gen_psd2_standard = 2;</code>
     * @param \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\NextGenPsd2Standard $var
     * @return $this
     */
    public function setNextGenPsd2Standard($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_NextGenPsd2Standard::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.PolishApiStandard polish_api_standard = 3;</code>
     * @return \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\PolishApiStandard
     */
    public function getPolishApiStandard()
    {
        return $this->readOneof(3);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.PolishApiStandard polish_api_standard = 3;</code>
     * @param \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\PolishApiStandard $var
     * @return $this
     */
    public function setPolishApiStandard($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_PolishApiStandard::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.ProviderSampleStandard provider_sample_standard = 4;</code>
     * @return \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\ProviderSampleStandard
     */
    public function getProviderSampleStandard()
    {
        return $this->readOneof(4);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.ProviderSampleStandard provider_sample_standard = 4;</code>
     * @param \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\ProviderSampleStandard $var
     * @return $this
     */
    public function setProviderSampleStandard($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_ProviderSampleStandard::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.StetPsd2Standard stet_psd2_standard = 5;</code>
     * @return \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\StetPsd2Standard
     */
    public function getStetPsd2Standard()
    {
        return $this->readOneof(5);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.StetPsd2Standard stet_psd2_standard = 5;</code>
     * @param \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\StetPsd2Standard $var
     * @return $this
     */
    public function setStetPsd2Standard($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_StetPsd2Standard::class);
        $this->writeOneof(5, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.StarlingApiStandard starling_api_standard = 6;</code>
     * @return \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\StarlingApiStandard
     */
    public function getStarlingApiStandard()
    {
        return $this->readOneof(6);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.StarlingApiStandard starling_api_standard = 6;</code>
     * @param \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\StarlingApiStandard $var
     * @return $this
     */
    public function setStarlingApiStandard($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_StarlingApiStandard::class);
        $this->writeOneof(6, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.CzechPsd2Standard czech_psd2_standard = 7;</code>
     * @return \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\CzechPsd2Standard
     */
    public function getCzechPsd2Standard()
    {
        return $this->readOneof(7);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.CzechPsd2Standard czech_psd2_standard = 7;</code>
     * @param \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\CzechPsd2Standard $var
     * @return $this
     */
    public function setCzechPsd2Standard($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_CzechPsd2Standard::class);
        $this->writeOneof(7, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.BudapestPsd2Standard budapest_psd2_standard = 8;</code>
     * @return \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\BudapestPsd2Standard
     */
    public function getBudapestPsd2Standard()
    {
        return $this->readOneof(8);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.BudapestPsd2Standard budapest_psd2_standard = 8;</code>
     * @param \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\BudapestPsd2Standard $var
     * @return $this
     */
    public function setBudapestPsd2Standard($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_BudapestPsd2Standard::class);
        $this->writeOneof(8, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.SlovakPsd2Standard slovak_psd2_standard = 9;</code>
     * @return \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\SlovakPsd2Standard
     */
    public function getSlovakPsd2Standard()
    {
        return $this->readOneof(9);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.tsp.bankconfig.BankConfig.SlovakPsd2Standard slovak_psd2_standard = 9;</code>
     * @param \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig\SlovakPsd2Standard $var
     * @return $this
     */
    public function setSlovakPsd2Standard($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_SlovakPsd2Standard::class);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getConfig()
    {
        return $this->whichOneof("config");
    }

}

