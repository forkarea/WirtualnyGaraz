<?php

namespace PioCMS\Models;

use PioCMS\Traits\ModelArrayConverter;

class VehicleWorkshop extends Model {

    // status
    const STATUS_WAITING = 0;
    const STATUS_ACTIVE = 1;

    public static $tableName = 'vehicle_workshop';
    public static $primary = 'id';

    /** @var string */
    private $title;

    /** @var string */
    private $alias;

    /** @var string */
    private $image;

    /** @var string */
    private $short_text;

    /** @var string */
    private $text;

    /** @var string */
    private $country;

    /** @var string */
    private $city;

    /** @var string */
    private $street;

    /** @var string */
    private $phone;

    /** @var string */
    private $website;

    /** @var string */
    private $mail;

    /** @var double */
    private $locationLatitude;

    /** @var double */
    private $locationLongtude;

    /** @var \DateTime */
    private $dateAdd;

    /** @var \DateTime */
    private $lastModify;

    /** @var int */
    private $views;

    /** @var int */
    private $promo;

    /** @var int */
    private $st;

    use ModelArrayConverter;

    public function __construct($id = null) {
        parent::__construct($id);
        parent::setTableName(self::$tableName);
        parent::setPrimaryKey(self::$primary);
        parent::setDateVars(array('dateAdd', 'lastModify'));

        $this->setSt(self::STATUS_WAITING);
    }

    function getTitle() {
        return $this->title;
    }

    function getAlias() {
        return $this->alias;
    }

    function getImage() {
        return $this->image;
    }

    function getShort_text() {
        return $this->short_text;
    }

    function getText() {
        return $this->text;
    }

    function getCountry() {
        return $this->country;
    }

    function getCity() {
        return $this->city;
    }

    function getStreet() {
        return $this->street;
    }

    function getPhone() {
        return $this->phone;
    }

    function getWebsite() {
        return $this->website;
    }

    function getMail() {
        return $this->mail;
    }

    function getLocationLatitude() {
        return $this->locationLatitude;
    }

    function getLocationLongtude() {
        return $this->locationLongtude;
    }

    function getDateAdd() {
        return $this->dateAdd;
    }

    function getLastModify() {
        return $this->lastModify;
    }

    function getViews() {
        return $this->views;
    }

    function getPromo() {
        return $this->promo;
    }

    function getSt() {
        return $this->st;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setAlias($alias) {
        $this->alias = $alias;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setShort_text($short_text) {
        $this->short_text = $short_text;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setCountry($country) {
        $this->country = $country;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setStreet($street) {
        $this->street = $street;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setWebsite($website) {
        $this->website = $website;
    }

    function setMail($mail) {
        $this->mail = $mail;
    }

    function setLocationLatitude($locationLatitude) {
        $this->locationLatitude = $locationLatitude;
    }

    function setLocationLongtude($locationLongtude) {
        $this->locationLongtude = $locationLongtude;
    }

    function setDateAdd(\DateTime $dateAdd) {
        $this->dateAdd = $dateAdd;
    }

    function setLastModify(\DateTime $lastModify) {
        $this->lastModify = $lastModify;
    }

    function setViews($views) {
        $this->views = $views;
    }

    function setPromo($promo) {
        $this->promo = $promo;
    }

    function setSt($st) {
        $this->st = $st;
    }

}
