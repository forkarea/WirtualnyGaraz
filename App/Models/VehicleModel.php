<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;

class VehicleModel extends Model implements ModelInterfaces {

    public static $_table_name = 'vehicle_models';
    public static $_primary = 'id';
    private $id;
    private $brand_id;
    private $name;

    use ModelArrayConverter;

    public function __construct($id = null) {
        $this->_primary = self::$_primary;
        $this->_table_name = self::$_table_name;
        parent::__construct($id);
    }

    public function getId() {
        return $this->id;
    }

    public function getBrand_id() {
        return $this->brand_id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setBrand_id($brand_id) {
        $this->brand_id = $brand_id;
    }

    public function setName($name) {
        $this->name = $name;
    }

}
