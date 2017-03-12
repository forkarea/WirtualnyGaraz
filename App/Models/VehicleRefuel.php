<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Models\Vehicle;

class VehicleRefuel extends Model implements ModelInterfaces {

    public static $_table_name = 'vehicle_refuels';
    public static $_primary = 'id';
    private $id;
    private $vehicle_id;
    private $date_add;
    private $date_tank;
    private $distance;
    private $galon;
	private $average_consumption = '0.00';
    private $price;
	private $price_per_galon = '0.00';
    private $ip;
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

    function getDate_add() {
        return $this->date_add;
    }

    function getDate_tank() {
        return $this->date_tank;
    }

    function getDistance() {
        return $this->distance;
    }

    function getGalon() {
        return $this->galon;
    }
	
	function getAverageConsumption() {
        return $this->average_consumption;
    }	
	
    function getPricePerGalon() {
        return $this->price_per_galon;
    }

    function getPrice() {
        return $this->price;
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

    function setDate_add($date_add) {
        $this->date_add = $date_add;
    }

    function setDate_tank($date_tank) {
        $this->date_tank = $date_tank;
    }

    function setDistance($distance) {
        $this->distance = $distance;
    }
	
	function setAverageConsumption($average_consumption) {
        $this->average_consumption = $average_consumption;
    }	

    function setGalon($galon) {
        $this->galon = $galon;
    }
	
    function setPricePerGalon($price_per_galon) {
        $this->price_per_galon = $price_per_galon;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    public function getVehicle() {
        if ($this->_vehicle === null) {
            $this->_vehicle = new Vehicle($this->getVehicle_id());
        }
        return $this->_vehicle;
    }

}
