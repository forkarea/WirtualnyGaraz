<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Traits\IP;

class UserDevice extends Model implements ModelInterfaces {

    public static $tableName = 'user_devices';
    public static $primary = 'id';

    /** @var int */
    private $userId;

    /** @var \DateTime */
    private $dateLogin;

    /** @var string */
    private $deviceId;

    /** @var \DateTime */
    private $dateSync;

    /** @var string */
    private $token;

    /** @var string */
    private $gcm;

    use ModelArrayConverter;
    use IP;

    public function __construct($id = null) {
        parent::__construct($id);
        parent::setTableName(self::$tableName);
        parent::setPrimaryKey(self::$primary);
        parent::setDateVars(array('dateLogin', 'dateSync'));

        $now = new \DateTime();
        $this->setDateSync($now);
        $this->setIp(get_client_ip());
    }

    function getUserId() {
        return $this->userId;
    }

    function getDateLogin() {
        return $this->dateLogin;
    }

    function getDeviceId() {
        return $this->deviceId;
    }

    function getDateSync() {
        return $this->dateSync;
    }

    function getToken() {
        return $this->token;
    }

    function getGcm() {
        return $this->gcm;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setDateLogin(\DateTime $dateLogin) {
        $this->dateLogin = $dateLogin;
    }

    function setDeviceId($deviceId) {
        $this->deviceId = $deviceId;
    }

    function setDateSync(\DateTime $dateSync) {
        $this->dateSync = $dateSync;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function setGcm($gcm) {
        $this->gcm = $gcm;
    }

}
