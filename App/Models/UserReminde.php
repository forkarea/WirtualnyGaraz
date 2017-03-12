<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;

class UserReminde extends Model implements ModelInterfaces {

    public static $_table_name = 'user_reminders';
    public static $_primary = 'id';
    private $id;
    private $user_id;
    private $vehicle_id;
    private $date_reminder;
    private $date_add;
    private $date_edit = "0000-00-00 00:00:00";
    private $description;
    private $ip;

    use ModelArrayConverter;

    public function __construct($id = null) {
        $this->_primary = self::$_primary;
        $this->_table_name = self::$_table_name;
        $this->ip = ip2long(get_client_ip());
        parent::__construct($id);
    }

    function getId() {
        return $this->id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getVehicle_id() {
        return $this->vehicle_id;
    }

    function getDate_reminder() {
        return $this->date_reminder;
    }

    function getDate_add() {
        return $this->date_add;
    }

    function getDate_edit() {
        return $this->date_edit;
    }

    function getDescription() {
        return $this->description;
    }

    function getIp() {
        return $this->ip;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setVehicle_id($vehicle_id) {
        $this->vehicle_id = $vehicle_id;
    }

    function setDate_reminder($date_reminder) {
        $this->date_reminder = $date_reminder;
    }

    function setDate_add($date_add) {
        $this->date_add = $date_add;
    }

    function setDate_edit($date_edit) {
        $this->date_edit = $date_edit;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

}
