<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Models\Vehicle;

class VehicleRepair extends Model implements ModelInterfaces {

    public static $_table_name = 'vehicle_repairs';
    public static $_primary = 'id';
    private $id;
    private $vehicle_id;
    private $description;
    private $price;
    private $date_add;
    private $date_repair;
    private $workshop_id;
    private $ip;
    public $_vehicleWorkshop;
    private $_vehicle;

    use ModelArrayConverter;

    public function __construct($id = null) {
        $this->_primary = self::$_primary;
        $this->_table_name = self::$_table_name;
        $this->date_add = date("Y-m-d H:i:s");
        $this->ip = ip2long(get_client_ip());
        parent::__construct($id);
    }

    function getId() {
        return $this->id;
    }

    function getVehicle_id() {
        return $this->vehicle_id;
    }

    function getDescription() {
        return $this->description;
    }

    function getPrice() {
        return $this->price;
    }

    function getDate_add() {
        return $this->date_add;
    }

    function getDate_repair() {
        return $this->date_repair;
    }

    function getWorkshop_id() {
        return $this->workshop_id;
    }

    function getIp() {
        return $this->ip;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setVehicle_id($vehicle_id) {
        $this->vehicle_id = $vehicle_id;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDate_add($date_add) {
        $this->date_add = $date_add;
    }

    function setDate_repair($date_repair) {
        $this->date_repair = $date_repair;
    }

    function setWorkshop_id($workshop_id) {
        $this->workshop_id = $workshop_id;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    public function setVehicleWorkshop(VehicleWorkshop $workshop) {
        $this->_vehicleWorkshop = $workshop;
    }

    public function getVehicleWorkshop() {
        return $this->_vehicleWorkshop;
    }

    public function convertToArray() {
        foreach (get_object_vars($this) as $key => $val) {
            if ($key[0] != "_") {
                $array[$key] = $val;
            }
        }
        if (!is_null($this->_vehicleWorkshop)) {
            $array['workshop'] = $this->_vehicleWorkshop->convertToArray();
        }
        return $array;
    }

    public function getVehicle() {
        if ($this->_vehicle === null) {
            $this->_vehicle = new Vehicle($this->getVehicle_id());
        }
        return $this->_vehicle;
    }

}
