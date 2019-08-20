<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: address.proto

namespace Io\Token\Proto\Common\Address;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A physical shipping/billing address. Modeled after OpenStreetMap format:
 * http://wiki.openstreetmap.org/wiki/Key:addr
 *
 * Generated from protobuf message <code>io.token.proto.common.address.Address</code>
 */
class Address extends \Google\Protobuf\Internal\Message
{
    /**
     * The house number (may contain letters, dashes or other characters). Addresses
     * describes ways to tag a single building with multiple addresses.
     *
     * Generated from protobuf field <code>string house_number = 1;</code>
     */
    private $house_number = '';
    /**
     * The name of a house. This is sometimes used in some countries like England
     * instead of (or in addition to) a house number.
     *
     * Generated from protobuf field <code>string house_name = 2;</code>
     */
    private $house_name = '';
    /**
     * The house numbers (range or list) of flats behind a door.
     *
     * Generated from protobuf field <code>string flats = 3;</code>
     */
    private $flats = '';
    /**
     * This special kind of housenumber relates to a settlement instead of a street.
     * Conscription numbers were introduced in the Austrio-Hungarian Empire and are
     * still in use in some parts of Europe, sometimes together with street-related
     * housenumbers which are also called orientation numbers.
     *
     * Generated from protobuf field <code>string conscription_number = 4;</code>
     */
    private $conscription_number = '';
    /**
     * The name of the respective street.
     *
     * Generated from protobuf field <code>string street = 5;</code>
     */
    private $street = '';
    /**
     * This is part of an address which refers to the name of some territorial zone
     * (usually like island, square) instead of a street. Should not be used together
     * with street.
     *
     * Generated from protobuf field <code>string place = 6;</code>
     */
    private $place = '';
    /**
     * The postal code of the building/area.
     *
     * Generated from protobuf field <code>string post_code = 7;</code>
     */
    private $post_code = '';
    /**
     * The name of the city as given in postal addresses of the building/area.
     *
     * Generated from protobuf field <code>string city = 8;</code>
     */
    private $city = '';
    /**
     * The ISO 3166-1 alpha-2 two letter country code in upper case.
     *
     * Generated from protobuf field <code>string country = 9;</code>
     */
    private $country = '';
    /**
     * Use this for a full-text, often multi-line, address if you find the structured
     * address fields unsuitable for denoting the address of this particular location.
     * Examples: "Fifth house on the left after the village oak, Smalltown, Smallcountry"
     * or "1200 West Sunset Boulevard Suite 110A". Beware that these strings can hardly
     * be parsed by software.
     *
     * Generated from protobuf field <code>string full = 10;</code>
     */
    private $full = '';
    /**
     * The hamlet.
     *
     * Generated from protobuf field <code>string hamlet = 11;</code>
     */
    private $hamlet = '';
    /**
     * If an address exists several times in a city. You have to add the name of the
     * settlement. See Australian definition of suburb.
     *
     * Generated from protobuf field <code>string suburb = 12;</code>
     */
    private $suburb = '';
    /**
     * The subdistrict.
     *
     * Generated from protobuf field <code>string subdistrict = 13;</code>
     */
    private $subdistrict = '';
    /**
     * The district.
     *
     * Generated from protobuf field <code>string district = 14;</code>
     */
    private $district = '';
    /**
     * The province. For Canada, uppercase two-letter postal abbreviations
     * (BC, AB, ON, QC, etc.) are used. In Russia a synonym region is widely
     * used
     *
     * Generated from protobuf field <code>string province = 15;</code>
     */
    private $province = '';
    /**
     * The state. For the US, uppercase two-letter postal abbreviations (AK, CA, HI, NY,
     * TX, WY, etc.) are used.
     *
     * Generated from protobuf field <code>string state = 16;</code>
     */
    private $state = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $house_number
     *           The house number (may contain letters, dashes or other characters). Addresses
     *           describes ways to tag a single building with multiple addresses.
     *     @type string $house_name
     *           The name of a house. This is sometimes used in some countries like England
     *           instead of (or in addition to) a house number.
     *     @type string $flats
     *           The house numbers (range or list) of flats behind a door.
     *     @type string $conscription_number
     *           This special kind of housenumber relates to a settlement instead of a street.
     *           Conscription numbers were introduced in the Austrio-Hungarian Empire and are
     *           still in use in some parts of Europe, sometimes together with street-related
     *           housenumbers which are also called orientation numbers.
     *     @type string $street
     *           The name of the respective street.
     *     @type string $place
     *           This is part of an address which refers to the name of some territorial zone
     *           (usually like island, square) instead of a street. Should not be used together
     *           with street.
     *     @type string $post_code
     *           The postal code of the building/area.
     *     @type string $city
     *           The name of the city as given in postal addresses of the building/area.
     *     @type string $country
     *           The ISO 3166-1 alpha-2 two letter country code in upper case.
     *     @type string $full
     *           Use this for a full-text, often multi-line, address if you find the structured
     *           address fields unsuitable for denoting the address of this particular location.
     *           Examples: "Fifth house on the left after the village oak, Smalltown, Smallcountry"
     *           or "1200 West Sunset Boulevard Suite 110A". Beware that these strings can hardly
     *           be parsed by software.
     *     @type string $hamlet
     *           The hamlet.
     *     @type string $suburb
     *           If an address exists several times in a city. You have to add the name of the
     *           settlement. See Australian definition of suburb.
     *     @type string $subdistrict
     *           The subdistrict.
     *     @type string $district
     *           The district.
     *     @type string $province
     *           The province. For Canada, uppercase two-letter postal abbreviations
     *           (BC, AB, ON, QC, etc.) are used. In Russia a synonym region is widely
     *           used
     *     @type string $state
     *           The state. For the US, uppercase two-letter postal abbreviations (AK, CA, HI, NY,
     *           TX, WY, etc.) are used.
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Address::initOnce();
        parent::__construct($data);
    }

    /**
     * The house number (may contain letters, dashes or other characters). Addresses
     * describes ways to tag a single building with multiple addresses.
     *
     * Generated from protobuf field <code>string house_number = 1;</code>
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->house_number;
    }

    /**
     * The house number (may contain letters, dashes or other characters). Addresses
     * describes ways to tag a single building with multiple addresses.
     *
     * Generated from protobuf field <code>string house_number = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setHouseNumber($var)
    {
        GPBUtil::checkString($var, True);
        $this->house_number = $var;

        return $this;
    }

    /**
     * The name of a house. This is sometimes used in some countries like England
     * instead of (or in addition to) a house number.
     *
     * Generated from protobuf field <code>string house_name = 2;</code>
     * @return string
     */
    public function getHouseName()
    {
        return $this->house_name;
    }

    /**
     * The name of a house. This is sometimes used in some countries like England
     * instead of (or in addition to) a house number.
     *
     * Generated from protobuf field <code>string house_name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setHouseName($var)
    {
        GPBUtil::checkString($var, True);
        $this->house_name = $var;

        return $this;
    }

    /**
     * The house numbers (range or list) of flats behind a door.
     *
     * Generated from protobuf field <code>string flats = 3;</code>
     * @return string
     */
    public function getFlats()
    {
        return $this->flats;
    }

    /**
     * The house numbers (range or list) of flats behind a door.
     *
     * Generated from protobuf field <code>string flats = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setFlats($var)
    {
        GPBUtil::checkString($var, True);
        $this->flats = $var;

        return $this;
    }

    /**
     * This special kind of housenumber relates to a settlement instead of a street.
     * Conscription numbers were introduced in the Austrio-Hungarian Empire and are
     * still in use in some parts of Europe, sometimes together with street-related
     * housenumbers which are also called orientation numbers.
     *
     * Generated from protobuf field <code>string conscription_number = 4;</code>
     * @return string
     */
    public function getConscriptionNumber()
    {
        return $this->conscription_number;
    }

    /**
     * This special kind of housenumber relates to a settlement instead of a street.
     * Conscription numbers were introduced in the Austrio-Hungarian Empire and are
     * still in use in some parts of Europe, sometimes together with street-related
     * housenumbers which are also called orientation numbers.
     *
     * Generated from protobuf field <code>string conscription_number = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setConscriptionNumber($var)
    {
        GPBUtil::checkString($var, True);
        $this->conscription_number = $var;

        return $this;
    }

    /**
     * The name of the respective street.
     *
     * Generated from protobuf field <code>string street = 5;</code>
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * The name of the respective street.
     *
     * Generated from protobuf field <code>string street = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setStreet($var)
    {
        GPBUtil::checkString($var, True);
        $this->street = $var;

        return $this;
    }

    /**
     * This is part of an address which refers to the name of some territorial zone
     * (usually like island, square) instead of a street. Should not be used together
     * with street.
     *
     * Generated from protobuf field <code>string place = 6;</code>
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * This is part of an address which refers to the name of some territorial zone
     * (usually like island, square) instead of a street. Should not be used together
     * with street.
     *
     * Generated from protobuf field <code>string place = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setPlace($var)
    {
        GPBUtil::checkString($var, True);
        $this->place = $var;

        return $this;
    }

    /**
     * The postal code of the building/area.
     *
     * Generated from protobuf field <code>string post_code = 7;</code>
     * @return string
     */
    public function getPostCode()
    {
        return $this->post_code;
    }

    /**
     * The postal code of the building/area.
     *
     * Generated from protobuf field <code>string post_code = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setPostCode($var)
    {
        GPBUtil::checkString($var, True);
        $this->post_code = $var;

        return $this;
    }

    /**
     * The name of the city as given in postal addresses of the building/area.
     *
     * Generated from protobuf field <code>string city = 8;</code>
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * The name of the city as given in postal addresses of the building/area.
     *
     * Generated from protobuf field <code>string city = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setCity($var)
    {
        GPBUtil::checkString($var, True);
        $this->city = $var;

        return $this;
    }

    /**
     * The ISO 3166-1 alpha-2 two letter country code in upper case.
     *
     * Generated from protobuf field <code>string country = 9;</code>
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * The ISO 3166-1 alpha-2 two letter country code in upper case.
     *
     * Generated from protobuf field <code>string country = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setCountry($var)
    {
        GPBUtil::checkString($var, True);
        $this->country = $var;

        return $this;
    }

    /**
     * Use this for a full-text, often multi-line, address if you find the structured
     * address fields unsuitable for denoting the address of this particular location.
     * Examples: "Fifth house on the left after the village oak, Smalltown, Smallcountry"
     * or "1200 West Sunset Boulevard Suite 110A". Beware that these strings can hardly
     * be parsed by software.
     *
     * Generated from protobuf field <code>string full = 10;</code>
     * @return string
     */
    public function getFull()
    {
        return $this->full;
    }

    /**
     * Use this for a full-text, often multi-line, address if you find the structured
     * address fields unsuitable for denoting the address of this particular location.
     * Examples: "Fifth house on the left after the village oak, Smalltown, Smallcountry"
     * or "1200 West Sunset Boulevard Suite 110A". Beware that these strings can hardly
     * be parsed by software.
     *
     * Generated from protobuf field <code>string full = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setFull($var)
    {
        GPBUtil::checkString($var, True);
        $this->full = $var;

        return $this;
    }

    /**
     * The hamlet.
     *
     * Generated from protobuf field <code>string hamlet = 11;</code>
     * @return string
     */
    public function getHamlet()
    {
        return $this->hamlet;
    }

    /**
     * The hamlet.
     *
     * Generated from protobuf field <code>string hamlet = 11;</code>
     * @param string $var
     * @return $this
     */
    public function setHamlet($var)
    {
        GPBUtil::checkString($var, True);
        $this->hamlet = $var;

        return $this;
    }

    /**
     * If an address exists several times in a city. You have to add the name of the
     * settlement. See Australian definition of suburb.
     *
     * Generated from protobuf field <code>string suburb = 12;</code>
     * @return string
     */
    public function getSuburb()
    {
        return $this->suburb;
    }

    /**
     * If an address exists several times in a city. You have to add the name of the
     * settlement. See Australian definition of suburb.
     *
     * Generated from protobuf field <code>string suburb = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setSuburb($var)
    {
        GPBUtil::checkString($var, True);
        $this->suburb = $var;

        return $this;
    }

    /**
     * The subdistrict.
     *
     * Generated from protobuf field <code>string subdistrict = 13;</code>
     * @return string
     */
    public function getSubdistrict()
    {
        return $this->subdistrict;
    }

    /**
     * The subdistrict.
     *
     * Generated from protobuf field <code>string subdistrict = 13;</code>
     * @param string $var
     * @return $this
     */
    public function setSubdistrict($var)
    {
        GPBUtil::checkString($var, True);
        $this->subdistrict = $var;

        return $this;
    }

    /**
     * The district.
     *
     * Generated from protobuf field <code>string district = 14;</code>
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * The district.
     *
     * Generated from protobuf field <code>string district = 14;</code>
     * @param string $var
     * @return $this
     */
    public function setDistrict($var)
    {
        GPBUtil::checkString($var, True);
        $this->district = $var;

        return $this;
    }

    /**
     * The province. For Canada, uppercase two-letter postal abbreviations
     * (BC, AB, ON, QC, etc.) are used. In Russia a synonym region is widely
     * used
     *
     * Generated from protobuf field <code>string province = 15;</code>
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * The province. For Canada, uppercase two-letter postal abbreviations
     * (BC, AB, ON, QC, etc.) are used. In Russia a synonym region is widely
     * used
     *
     * Generated from protobuf field <code>string province = 15;</code>
     * @param string $var
     * @return $this
     */
    public function setProvince($var)
    {
        GPBUtil::checkString($var, True);
        $this->province = $var;

        return $this;
    }

    /**
     * The state. For the US, uppercase two-letter postal abbreviations (AK, CA, HI, NY,
     * TX, WY, etc.) are used.
     *
     * Generated from protobuf field <code>string state = 16;</code>
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * The state. For the US, uppercase two-letter postal abbreviations (AK, CA, HI, NY,
     * TX, WY, etc.) are used.
     *
     * Generated from protobuf field <code>string state = 16;</code>
     * @param string $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkString($var, True);
        $this->state = $var;

        return $this;
    }

}

