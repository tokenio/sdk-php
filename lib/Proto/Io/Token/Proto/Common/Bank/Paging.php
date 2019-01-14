<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: bankinfo.proto

namespace Io\Token\Proto\Common\Bank;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.bank.Paging</code>
 */
class Paging extends \Google\Protobuf\Internal\Message
{
    /**
     * Index of current page
     *
     * Generated from protobuf field <code>int32 page = 1;</code>
     */
    private $page = 0;
    /**
     * Number of records per page
     *
     * Generated from protobuf field <code>int32 per_page = 2;</code>
     */
    private $per_page = 0;
    /**
     * Number of pages in total
     *
     * Generated from protobuf field <code>int32 page_count = 3;</code>
     */
    private $page_count = 0;
    /**
     * Number of records in total
     *
     * Generated from protobuf field <code>int32 total_count = 4;</code>
     */
    private $total_count = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $page
     *           Index of current page
     *     @type int $per_page
     *           Number of records per page
     *     @type int $page_count
     *           Number of pages in total
     *     @type int $total_count
     *           Number of records in total
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Bankinfo::initOnce();
        parent::__construct($data);
    }

    /**
     * Index of current page
     *
     * Generated from protobuf field <code>int32 page = 1;</code>
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Index of current page
     *
     * Generated from protobuf field <code>int32 page = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setPage($var)
    {
        GPBUtil::checkInt32($var);
        $this->page = $var;

        return $this;
    }

    /**
     * Number of records per page
     *
     * Generated from protobuf field <code>int32 per_page = 2;</code>
     * @return int
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * Number of records per page
     *
     * Generated from protobuf field <code>int32 per_page = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setPerPage($var)
    {
        GPBUtil::checkInt32($var);
        $this->per_page = $var;

        return $this;
    }

    /**
     * Number of pages in total
     *
     * Generated from protobuf field <code>int32 page_count = 3;</code>
     * @return int
     */
    public function getPageCount()
    {
        return $this->page_count;
    }

    /**
     * Number of pages in total
     *
     * Generated from protobuf field <code>int32 page_count = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setPageCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_count = $var;

        return $this;
    }

    /**
     * Number of records in total
     *
     * Generated from protobuf field <code>int32 total_count = 4;</code>
     * @return int
     */
    public function getTotalCount()
    {
        return $this->total_count;
    }

    /**
     * Number of records in total
     *
     * Generated from protobuf field <code>int32 total_count = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setTotalCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->total_count = $var;

        return $this;
    }

}
