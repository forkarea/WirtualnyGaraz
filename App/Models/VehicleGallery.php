<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Traits\IP;

class VehicleGallery extends Model implements ModelInterfaces {

    public static $tableName = 'vehicle_gallery';
    public static $primary = 'id';

    /** @var int */
    private $vehicleId;

    /** @var \DateTime */
    private $dateAdd;

    /** @var string */
    private $filename;

    /** @var string */
    private $path;

    use ModelArrayConverter;
    use IP;

    public function __construct($id = null) {
        parent::__construct($id);
        parent::setTableName(self::$tableName);
        parent::setPrimaryKey(self::$primary);
        parent::setDateVars(array('dateAdd'));

        $now = new \DateTime();
        $this->setDateAdd($now);
        $this->setIp(get_client_ip());
    }

    function getVehicleId() {
        return $this->vehicleId;
    }

    function getDateAdd() {
        return $this->dateAdd;
    }

    function getFilename() {
        return $this->filename;
    }

    function getPath() {
        return $this->path;
    }

    function setVehicleId($vehicleId) {
        $this->vehicleId = $vehicleId;
    }

    function setDateAdd(\DateTime $dateAdd) {
        $this->dateAdd = $dateAdd;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setPath($path) {
        $this->path = $path;
    }

}
