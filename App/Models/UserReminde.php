<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Traits\IP;

class UserReminde extends Model implements ModelInterfaces {

    public static $tableName = 'user_reminders';
    public static $primary = 'id';

    /** @var int */
    private $userId;

    /** @var int */
    private $vehicleId;

    /** @var \DateTime */
    private $dateReminder;

    /** @var \DateTime */
    private $dateAdd;

    /** @var \DateTime */
    private $dateEdit;

    /** @var string */
    private $description;

    use ModelArrayConverter;
    use IP;

    public function __construct($id = null) {
        parent::__construct($id);
        parent::setTableName(self::$tableName);
        parent::setPrimaryKey(self::$primary);
        parent::setDateVars(array('dateReminder', 'dateAdd', 'dateEdit'));

        $now = new \DateTime();
        $this->setDate_reminder($now);
        $this->setIp(get_client_ip());
    }

    function getUserId() {
        return $this->userId;
    }

    function getVehicleId() {
        return $this->vehicleId;
    }

    function getDateReminder() {
        return $this->dateReminder;
    }

    function getDateAdd() {
        return $this->dateAdd;
    }

    function getDateEdit() {
        return $this->dateEdit;
    }

    function getDescription() {
        return $this->description;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setVehicleId($vehicleId) {
        $this->vehicleId = $vehicleId;
    }

    function setDateReminder(\DateTime $dateReminder) {
        $this->dateReminder = $dateReminder;
    }

    function setDateAdd(\DateTime $dateAdd) {
        $this->dateAdd = $dateAdd;
    }

    function setDateEdit(\DateTime $dateEdit) {
        $this->dateEdit = $dateEdit;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
