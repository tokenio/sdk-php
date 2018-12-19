<?php

namespace Tokenio;

use Google\Protobuf\Internal\RepeatedField;

class PagedList
{
    /**
     * @var RepeatedField
     */
    private $list;

    /**
     * @var string
     */
    private $offset;

    /**
     * Construct the PagedList.
     *
     * @param RepeatedField $list
     * @param string $offset
     */
    public function __construct($list, $offset)
    {
        $this->list = $list;
        $this->offset = $offset;
    }

    /**
     * @return RepeatedField
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @return string
     */
    public function getOffset()
    {
        return $this->offset;
    }
}
