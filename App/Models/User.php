<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Traits\IP;

class User extends Model implements ModelInterfaces {

    // account type
    const ACCOUNT_TYPE_USER = 1;
    // status
    const STATUS_WAITING = "waiting";
    const STATUS_ACTIVE = "active";
    const STATUS_BLOCKED = "blocked";
    const STATUS_DELETED = "deleted";

    public static $tableName = 'users';
    public static $primary = 'id';

    /** @var string */
    private $password;

    /** @var string */
    private $mail;

    /** @var string */
    private $firstName;

    /** @var tinyint */
    private $accountType;

    /** @var \DateTime */
    private $dateRegister;

    /** @var \DateTime */
    private $dateLastLogin;

    /** @var string */
    private $code;

    /** @var string */
    private $status;

    use ModelArrayConverter;
    use IP;

    public function __construct($id = null) {
        parent::__construct($id);
        parent::setTableName(self::$tableName);
        parent::setPrimaryKey(self::$primary);
        parent::setDateVars(array('dateRegister', 'dateLastLogin'));
        parent::setMapper(array(
            'id' => self::$primary,
            'password' => 'password',
            'mail' => 'mail',
            'firstName' => 'first_name',
            'accountType' => 'account_type',
            'dateRegister' => 'date_register',
            'dateLastLogin' => 'date_last_login',
            'code' => 'code',
            'status' => 'status',
            'ip' => 'ip'
        ));

        $now = new \DateTime();
        $this->setDateRegister($now);
        $this->setDateLastLogin($now);
        $this->setIp(get_client_ip());
        $this->setAccountType(self::ACCOUNT_TYPE_USER);
        $this->setStatus(self::STATUS_WAITING);
    }

    function getPassword() {
        return $this->password;
    }

    function getMail() {
        return $this->mail;
    }

    function getFirst_name() {
        return $this->firstName;
    }

    function getAccountType() {
        return $this->accountType;
    }

    function getDateRegister() {
        return $this->dateRegister;
    }

    function getDateLastLogin() {
        return $this->dateLastLogin;
    }

    function getCode() {
        return $this->code;
    }

    function getStatus() {
        return $this->status;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setMail($mail) {
        $this->mail = $mail;
    }

    function setFirst_name($first_name) {
        $this->firstName = $first_name;
    }

    function setAccountType($accountType) {
        $this->accountType = $accountType;
    }

    function setDateRegister(\DateTime $dateRegister) {
        $this->dateRegister = $dateRegister;
    }

    function setDateLastLogin(\DateTime $dateLastLogin) {
        $this->dateLastLogin = $dateLastLogin;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setStatus($status) {
        $this->status = $status;
    }

}
