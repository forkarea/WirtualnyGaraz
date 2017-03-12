<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;

class VehicleWorkshop extends Model implements ModelInterfaces {

    public static $_table_name = 'vehicle_workshop';
    public static $_primary = 'id';
    private $id;
    private $title = '';
    private $alias = '';
    private $image = '';
    private $short_text = '';
    private $text = '';
    private $country = '';
    private $city = '';
    private $street = '';
    private $phone = '';
    private $website = '';
    private $mail = '';
    private $location_latitude = '';
    private $location_longtude = '';
    private $date_add = '';
    private $last_modify = '';
    private $views = '';
    private $promo = '';
    private $st = '0';

    use ModelArrayConverter;

    public function __construct($id = null) {
        $this->_primary = self::$_primary;
        $this->_table_name = self::$_table_name;
        parent::__construct($id);
    }

    function getId() {
        return $this->id;
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

    function getLocation_latitude() {
        return $this->location_latitude;
    }

    function getLocation_longtude() {
        return $this->location_longtude;
    }

    function getDate_add() {
        return $this->date_add;
    }

    function getLast_modify() {
        return $this->last_modify;
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

    function setId($id) {
        $this->id = $id;
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

    function setLocation_latitude($location_latitude) {
        $this->location_latitude = $location_latitude;
    }

    function setLocation_longtude($location_longtude) {
        $this->location_longtude = $location_longtude;
    }

    function setDate_add($date_add) {
        $this->date_add = $date_add;
    }

    function setLast_modify($last_modify) {
        $this->last_modify = $last_modify;
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
