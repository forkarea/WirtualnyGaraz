<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;

class UserDevice extends Model implements ModelInterfaces {

    public static $_table_name = 'user_devices';
    public static $_primary = 'id';
    private $id;
    private $user_id;
    private $date_login;
    private $device_id = "";
	private $date_sync = "0000-00-00 00:00:00";
    private $token = "";
    private $ip;
    private $gcm = "";

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

    function getDate_login() {
        return $this->date_login;
    }

    function getDevice_id() {
        return $this->device_id;
    }

    function getToken() {
        return $this->token;
    }

    function getIp() {
        return $this->ip;
    }

    function getGcm() {
        return $this->gcm;
    }
	
    function getDateSync() {
        return $this->date_sync;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setDate_login($date_login) {
        $this->date_login = $date_login;
    }

    function setDevice_id($device_id) {
        $this->device_id = $device_id;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setGcm($gcm) {
        $this->gcm = $gcm;
    }
	
    function setDateSync($date_sync) {
        $this->date_sync = $date_sync;
    }

}
