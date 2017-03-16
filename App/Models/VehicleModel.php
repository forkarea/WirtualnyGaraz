<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;

class VehicleModel extends Model implements ModelInterfaces {

    public static $tableName = 'vehicle_models';
    public static $primary = 'id';

    /** @var int */
    private $brandId;

    /** @var string */
    private $name;

    use ModelArrayConverter;

    public function __construct($id = null) {
        parent::__construct($id);
        parent::setTableName(self::$tableName);
        parent::setPrimaryKey(self::$primary);
    }

    function getBrandId() {
        return $this->brandId;
    }

    function getName() {
        return $this->name;
    }

    function setBrandId($brandId) {
        $this->brandId = $brandId;
    }

    function setName($name) {
        $this->name = $name;
    }

}
