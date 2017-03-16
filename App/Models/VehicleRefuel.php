<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Traits\IP;
use PioCMS\Models\Vehicle;

class VehicleRefuel extends Model implements ModelInterfaces {

    public static $tableName = 'vehicle_refuels';
    public static $primary = 'id';

    /** @var int */
    private $vehicleId;

    /** @var DateTime */
    private $dateAdd;

    /** @var \DateTime */
    private $dateTank;

    /** @var double */
    private $distance;

    /** @var double */
    private $galon;

    /** @var double */
    private $averageConsumption;

    /** @var double */
    private $price;

    /** @var double */
    private $pricePerGalon;

    /** @var Vehicle */
    private $vehicle;

    use ModelArrayConverter;
    use IP;

    public function __construct($id = null) {
        $this->primary = self::$primary;
        $this->tableName = self::$tableName;
        $this->hiddenVars = array('tableName', 'primary', 'vehicle');
        $this->dateVars = array('dateAdd');

        $now = new \DateTime();
        $this->setDate_add($now);
        $this->setAverageConsumption(0.00);
        $this->setPricePerGalon(0.00);
        $this->setPrice(0.00);
        $this->setIp(get_client_ip());
        parent::__construct($id);
    }

    function getVehicleId() {
        return $this->vehicleId;
    }

    function getDateAdd() {
        return $this->dateAdd;
    }

    function getDateTank() {
        return $this->dateTank;
    }

    function getDistance() {
        return $this->distance;
    }

    function getGalon() {
        return $this->galon;
    }

    function getAverageConsumption() {
        return $this->averageConsumption;
    }

    function getPrice() {
        return $this->price;
    }

    function getPricePerGalon() {
        return $this->pricePerGalon;
    }

    function setVehicleId($vehicleId) {
        $this->vehicleId = $vehicleId;
    }

    function setDateAdd(DateTime $dateAdd) {
        $this->dateAdd = $dateAdd;
    }

    function setDateTank(\DateTime $dateTank) {
        $this->dateTank = $dateTank;
    }

    function setDistance($distance) {
        $this->distance = $distance;
    }

    function setGalon($galon) {
        $this->galon = $galon;
    }

    function setAverageConsumption($averageConsumption) {
        $this->averageConsumption = $averageConsumption;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setPricePerGalon($pricePerGalon) {
        $this->pricePerGalon = $pricePerGalon;
    }

    public function getVehicle() {
        if ($this->vehicle === null) {
            $this->vehicle = new Vehicle($this->getVehicle_id());
        }
        return $this->vehicle;
    }

}
