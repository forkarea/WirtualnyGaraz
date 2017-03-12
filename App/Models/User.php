<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;

class User extends Model implements ModelInterfaces {

    public static $_table_name = 'users';
    public static $_primary = 'id';
    private $id;
    private $password;
    private $mail;
    private $first_name;
    private $account_type = 1;
    private $date_register;
    private $date_last_login = '0000-00-00 00:00:00';
    private $code = '';
    private $status = 'waiting';
    private $ip;

    use ModelArrayConverter;

    public function __construct($id = null) {
        $this->_primary = self::$_primary;
        $this->_table_name = self::$_table_name;
        $this->date_register = date("Y-m-d H:i:s");
        $this->ip = ip2long(get_client_ip());
        parent::__construct($id);
    }

    function getId() {
        return $this->id;
    }

    function getPassword() {
        return $this->password;
    }

    function getMail() {
        return $this->mail;
    }

    function getFirst_name() {
        return $this->first_name;
    }

    function getAccount_type() {
        return $this->account_type;
    }

    function getDate_register() {
        return $this->date_register;
    }

    function getDate_last_login() {
        return $this->date_last_login;
    }

    function getCode() {
        return $this->code;
    }

    function getStatus() {
        return $this->status;
    }

    function getIp() {
        return $this->ip;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setMail($mail) {
        $this->mail = $mail;
    }

    function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    function setAccount_type($account_type) {
        $this->account_type = $account_type;
    }

    function setDate_register($date_register) {
        $this->date_register = $date_register;
    }

    function setDate_last_login($date_last_login) {
        $this->date_last_login = $date_last_login;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

}
