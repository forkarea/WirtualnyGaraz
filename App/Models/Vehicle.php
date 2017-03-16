<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Traits\IP;
use PioCMS\Models\VehicleBrand;
use PioCMS\Models\VehicleModel;
use PioCMS\Models\VehicleRefuel;
use PioCMS\Models\VehicleGallery;
use PioCMS\Models\Repository\RepositoryVehicleRefuel;
use PioCMS\Models\Repository\RepositoryVehicleRepair;
use PioCMS\Models\Repository\RepositoryVehicleGallery;

class Vehicle extends Model implements ModelInterfaces {

    // status
    const STATUS_WAITING = 0;
    const STATUS_ACTIVE = 1;

    public static $tableName = 'vehicles';
    public static $primary = 'id';

    /** @var int */
    private $userId;
    //private $vehicle_id;
    /** @var int */
    private $brandId;

    /** @var int */
    private $modelId;

    /** @var int */
    private $year;

    /** @var string */
    private $fuel;

    /** @var string */
    private $transmission;

    /** @var string */
    private $colour;

    /** @var int */
    private $doors;

    /** @var string */
    private $carType;

    /** @var double */
    private $price;

    /** @var \DateTime */
    private $datePurchase;

    /** @var string */
    private $engine;

    /** @var string */
    private $power;

    /** @var double */
    private $mileage;

    /** @var string */
    private $unit;

    /** @var double */
    private $totalMileage;

    /** @var double */
    private $totalRefuel;

    /** @var double */
    private $totalExpenses;

    /** @var \DateTime */
    private $dateEdit;

    /** @var int */
    private $status;

    /** @var VehicleBrand */
    public $vehicleBrand;

    /** @var VehicleModel */
    public $vehicleModel;

    /** @var VehicleWorkshop */
    public $vehicleWorkshop;

    /** @var VehicleGallery */
    public $vehicleGallery;

    /** @var VehicleRefuel */
    private $vehicleRefuel;

    /** @var VehicleRepair */
    private $vehicleRepair;

    use ModelArrayConverter;
    use IP;

    public function __construct($id = null) {
        parent::__construct($id);
        parent::setTableName(self::$tableName);
        parent::setPrimaryKey(self::$primary);
        parent::setHiddenVars(array(
            'tableName', 'primary', 'vehicleBrand', 'vehicleModel',
            'vehicleWorkshop', 'vehicleGallery', 'vehicleRefuel',
            'vehicleRepair'
        ));
        parent::setDateVars(array('datePurchase', 'dateEdit'));

        $now = new \DateTime();
        $this->setTotalMileage(0.00);
        $this->setTotalRefuel(0.00);
        $this->setTotalExpenses(0.00);
        $this->setDateEdit($now);
        $this->setStatus(self::STATUS_WAITING);
        $this->setIp(get_client_ip());
    }

    function getUserId() {
        return $this->userId;
    }

    function getBrandId() {
        return $this->brandId;
    }

    function getModelId() {
        return $this->modelId;
    }

    function getYear() {
        return $this->year;
    }

    function getFuel() {
        return $this->fuel;
    }

    function getTransmission() {
        return $this->transmission;
    }

    function getColour() {
        return $this->colour;
    }

    function getDoors() {
        return $this->doors;
    }

    function getCarType() {
        return $this->carType;
    }

    function getPrice() {
        return $this->price;
    }

    function getDatePurchase() {
        return $this->datePurchase;
    }

    function getEngine() {
        return $this->engine;
    }

    function getPower() {
        return $this->power;
    }

    function getMileage() {
        return $this->mileage;
    }

    function getUnit() {
        return $this->unit;
    }

    function getTotalMileage() {
        return $this->totalMileage;
    }

    function getTotalRefuel() {
        return $this->totalRefuel;
    }

    function getTotalExpenses() {
        return $this->totalExpenses;
    }

    function getDateEdit() {
        return $this->dateEdit;
    }

    function getStatus() {
        return $this->status;
    }

    function getVehicleBrand() {
        return $this->vehicleBrand;
    }

    function getVehicleModel() {
        return $this->vehicleModel;
    }

    function getVehicleGallery() {
        return $this->vehicleGallery;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setBrandId($brandId) {
        $this->brandId = $brandId;
    }

    function setModelId($modelId) {
        $this->modelId = $modelId;
    }

    function setYear($year) {
        $this->year = $year;
    }

    function setFuel($fuel) {
        $this->fuel = $fuel;
    }

    function setTransmission($transmission) {
        $this->transmission = $transmission;
    }

    function setColour($colour) {
        $this->colour = $colour;
    }

    function setDoors($doors) {
        $this->doors = $doors;
    }

    function setCarType($carType) {
        $this->carType = $carType;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDatePurchase(\DateTime $datePurchase) {
        $this->datePurchase = $datePurchase;
    }

    function setEngine($engine) {
        $this->engine = $engine;
    }

    function setPower($power) {
        $this->power = $power;
    }

    function setMileage($mileage) {
        $this->mileage = $mileage;
    }

    function setUnit($unit) {
        $this->unit = $unit;
    }

    function setTotalMileage($totalMileage) {
        $this->totalMileage = $totalMileage;
    }

    function setTotalRefuel($totalRefuel) {
        $this->totalRefuel = $totalRefuel;
    }

    function setTotalExpenses($totalExpenses) {
        $this->totalExpenses = $totalExpenses;
    }

    function setDateEdit(\DateTime $dateEdit) {
        $this->dateEdit = $dateEdit;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setVehicleBrand(VehicleBrand $vehicleBrand) {
        $this->vehicleBrand = $vehicleBrand;
    }

    function setVehicleModel(VehicleModel $vehicleModel) {
        $this->vehicleModel = $vehicleModel;
    }

    function setVehicleGallery(VehicleGallery $vehicleGallery) {
        $this->vehicleGallery = $vehicleGallery;
    }

    public function getBrandModel() {
        if (is_null($this->vehicleBrand)) {
            $this->vehicleBrand = new VehicleBrand($this->brandId);
        }
        if (is_null($this->vehicleModel)) {
            $this->vehicleModel = new VehicleModel($this->modelId);
        }
        return $this->vehicleBrand->getName() . ' ' . $this->vehicleModel->getName();
    }

    public function getVehicleWorkshop() {
        return $this->vehicleWorkshop;
    }

    public function getEngineFuel() {
        return $this->engine . ' ' . $this->fuel;
    }

    public function getAlias() {
        return str_replace(' ', '-', strtolower($this->getBrandModel()));
    }

    public function getVehicleRefuel() {
        if ($this->vehicleRefuel === null) {
            $vehicleRefuelRepository = new RepositoryVehicleRefuel($this->database);
            $vehicleRefuelRepository->criteria(array('orderby' => array(VehicleRefuel::$tableName . '.id', 'DESC'), 'where' => array('vehicle_id', $this->getId())))->paginate(1, 5)->getAll();
            $this->vehicleRefuel = $vehicleRefuelRepository;
        }
        return $this->vehicleRefuel;
    }

    public function getVehicleRefuelAll() {
        if ($this->vehicleRefuel === null) {
            $vehicleRefuelRepository = new RepositoryVehicleRefuel($this->database);
            $vehicleRefuelRepository->criteria(array('orderby' => array(VehicleRefuel::$tableName . '.id', 'DESC'), 'where' => array('vehicle_id', $this->getId())))->getAll();
            $this->vehicleRefuel = $vehicleRefuelRepository;
        }
        return $this->vehicleRefuel;
    }

    public function getVehicleRepair($count = 5) {
        if ($this->vehicleRepair === null) {
            $vehicleRepairRepository = new RepositoryVehicleRepair($this->database);
            $vehicleRepairRepository->getRepairWorkshopList($count)->getAll();
            $this->vehicleRepair = $vehicleRepairRepository;
        }
        return $this->vehicleRepair;
    }

    public function getPhotos() {
        if ($this->vehicleGallery === null) {
            $vehicleGalleryRepository = new RepositoryVehicleGallery($this->database);
            $vehicleGalleryRepository->criteria(array('orderby' => array(VehicleGallery::$tableName . '.id', 'DESC'), 'where' => array('vehicle_id', $this->getId())))->getAll();
            $this->vehicleGallery = $vehicleGalleryRepository;
        }
        return $this->vehicleGallery;
    }

    public function convertToArray() {
        $array = array();
        foreach (get_object_vars($this) as $key => $val) {
            if (!in_array($key, $this->hiddenVars)) {
                if (in_array($key, $this->dateVars)) {
                    $val = \PioCMS\Models\Model::formatDateTime($val);
                }
                $array[$key] = $val;
            }
        }
        if ($this->vehicleRefuel !== null) {
            foreach ($this->vehicleRefuel as $key => $vehicleRefuel) {
                $array['vehicleRefuel'][$key] = $vehicleRefuel->convertToArray();
            }
        }

        if ($this->vehicleRepair !== null) {
            foreach ($this->vehicleRepair as $key => $vehicleRepair) {
                $array['vehicleRepair'][$key] = $vehicleRepair->convertToArray();
            }
        }

        if ($this->vehicleGallery !== null) {
            if (!is_array($this->vehicleGallery)) {
                $this->vehicleGallery = array($this->vehicleGallery);
            }
            foreach ($this->vehicleGallery as $key => $vehicleGallery) {
                $array['vehicleGallery'][$key] = $vehicleGallery->convertToArray();
            }
        }

        if ($this->vehicleWorkshop !== null) {
            $array['vehicleWorkshop'] = $this->vehicleWorkshop->convertToArray();
        }

        if ($this->vehicleBrand !== null) {
            $array['vehicleBrand'] = $this->vehicleBrand->convertToArray();
        }

        if ($this->vehicleModel !== null) {
            $array['vehicleModel'] = $this->vehicleModel->convertToArray();
        }
        return $array;
    }

}
