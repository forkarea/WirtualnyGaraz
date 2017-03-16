<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Models\Vehicle;

class VehicleRepair extends Model implements ModelInterfaces {

    public static $tableName = 'vehicle_repairs';
    public static $primary = 'id';

    /** @var int */
    private $vehicleId;

    /** @var string */
    private $description;

    /** @var double */
    private $price;

    /** @var \DateTime */
    private $dateAdd;

    /** @var \DateTime */
    private $dateRepair;

    /** @var int */
    private $workshopId;

    /** @var VehicleWorkshop */
    public $vehicleWorkshop;

    /** @var Vehicle */
    private $vehicle;

    use ModelArrayConverter;

    public function __construct($id = null) {
        parent::__construct($id);
        parent::setTableName(self::$tableName);
        parent::setPrimaryKey(self::$primary);
        parent::setHiddenVars(array(
            'tableName', 'primary', 'vehicle', 'vehicleWorkshop'
        ));
        parent::setDateVars(array('dateAdd', 'dateRepair'));

        $now = new \DateTime();
        $this->setDate_add($now);
        $this->setIp(get_client_ip());
    }

    function getVehicleId() {
        return $this->vehicleId;
    }

    function getDescription() {
        return $this->description;
    }

    function getPrice() {
        return $this->price;
    }

    function getDateAdd() {
        return $this->dateAdd;
    }

    function getDateRepair() {
        return $this->dateRepair;
    }

    function getWorkshopId() {
        return $this->workshopId;
    }

    function getVehicleWorkshop() {
        return $this->vehicleWorkshop;
    }

    function setVehicleId($vehicleId) {
        $this->vehicleId = $vehicleId;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDateAdd(\DateTime $dateAdd) {
        $this->dateAdd = $dateAdd;
    }

    function setDateRepair(\DateTime $dateRepair) {
        $this->dateRepair = $dateRepair;
    }

    function setWorkshopId($workshopId) {
        $this->workshopId = $workshopId;
    }

    function setVehicleWorkshop(VehicleWorkshop $vehicleWorkshop) {
        $this->vehicleWorkshop = $vehicleWorkshop;
    }

    public function convertToArray() {
        foreach (get_object_vars($this) as $key => $val) {
            if (!in_array($key, $this->hiddenVars)) {
                if (in_array($key, $this->dateVars)) {
                    $val = \PioCMS\Models\Model::formatDateTime($val);
                }
                $array[$key] = $val;
            }
        }
        if (!is_null($this->vehicleWorkshop)) {
            $array['workshop'] = $this->vehicleWorkshop->convertToArray();
        }
        return $array;
    }

    public function getVehicle() {
        if ($this->vehicle === null) {
            $this->vehicle = new Vehicle($this->getVehicle_id());
        }
        return $this->vehicle;
    }

}
