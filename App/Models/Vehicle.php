<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;
use PioCMS\Models\VehicleBrand;
use PioCMS\Models\VehicleModel;
use PioCMS\Models\VehicleRefuel;
use PioCMS\Models\VehicleGallery;
use PioCMS\Models\Repository\RepositoryVehicleRefuel;
use PioCMS\Models\Repository\RepositoryVehicleRepair;
use PioCMS\Models\Repository\RepositoryVehicleGallery;

class Vehicle extends Model implements ModelInterfaces {

    public static $_table_name = 'vehicles';
    public static $_primary = 'id';
    private $id;
    private $user_id;
    //private $vehicle_id;
    private $brand_id;
    private $model_id;
    private $year;
    private $fuel;
    private $transmission;
    private $colour;
    private $doors;
    private $car_type;
    private $price;
    private $date_purchase;
    private $engine;
    private $power;
    private $mileage;
    private $unit;
    private $total_mileage = '0.00';
    private $total_refuel = '0.00';
    private $total_expenses = '0.00';
	private $date_edit = "0000-00-00 00:00:00";
	private $status = 0;
    private $ip;
    public $_vehicleBrand;
    public $_vehicleModel;
    public $_vehicleWorkshop;
	public $_vehicleGallery;
    private $_vehicleRefuel = null;
    private $_vehicleRepair = null;
	
    use ModelArrayConverter;

    public function __construct($id = null) {
        $this->_primary = self::$_primary;
        $this->_table_name = self::$_table_name;
        $this->ip = ip2long(get_client_ip());
        parent::__construct($id);
    }

    public function getId() {
        return $this->id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getVehicle_id() {
        return $this->vehicle_id;
    }

    public function getBrand() {
        return $this->brand_id;
    }

    public function getModel() {
        return $this->model_id;
    }

    public function getYear() {
        return $this->year;
    }

    public function getFuel() {
        return $this->fuel;
    }

    public function getTransmission() {
        return $this->transmission;
    }

    public function getColour() {
        return $this->colour;
    }

    public function getDoors() {
        return $this->doors;
    }

    public function getCar_type() {
        return $this->car_type;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDate_purchase() {
        return $this->date_purchase;
    }

    public function getEngine() {
        return $this->engine;
    }

    public function getPower() {
        return $this->power;
    }

    public function getMileage() {
        return $this->mileage;
    }

    public function getUnit() {
        return $this->unit;
    }

    public function getStatus() {
        return $this->status;
    }
	
    public function getDateEdit() {
        return $this->date_edit;
    }
    public function getIp() {
        return $this->ip;
    }

    public function getTotalMileage() {
        return $this->total_mileage;
    }

    public function getTotalRefuel() {
        return $this->total_refuel;
    }

    public function getTotalExpenses() {
        return $this->total_expenses;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function setVehicle_id($vehicle_id) {
        $this->vehicle_id = $vehicle_id;
    }

    public function setBrand($brand_id) {
        $this->brand_id = $brand_id;
    }

    public function setModel($model_id) {
        $this->model_id = $model_id;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function setFuel($fuel) {
        $this->fuel = $fuel;
    }

    public function setTransmission($transmission) {
        $this->transmission = $transmission;
    }

    public function setColour($colour) {
        $this->colour = $colour;
    }

    public function setDoors($doors) {
        $this->doors = $doors;
    }

    public function setCar_type($car_type) {
        $this->car_type = $car_type;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setDate_purchase($date_purchase) {
        $this->date_purchase = $date_purchase;
    }

    public function setEngine($engine) {
        $this->engine = $engine;
    }

    public function setPower($power) {
        $this->power = $power;
    }

    public function setMileage($mileage) {
        $this->mileage = $mileage;
    }

    public function setUnit($unit) {
        $this->unit = $unit;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
	
    public function setDateEdit($date_edit) {
        $this->date_edit = $date_edit;
    }
	
    public function setIp($ip) {
        $this->ip = $ip;
    }

    public function setTotalMileage($total_mileage) {
        $this->total_mileage = $total_mileage;
    }

    public function setTotalRefuel($total_refuel) {
        $this->total_refuel = $total_refuel;
    }

    public function setTotalExpenses($total_expenses) {
        $this->total_expenses = $total_expenses;
    }

    public function setVehicleBrand(VehicleBrand $brand) {
        $this->_vehicleBrand = $brand;
    }

    public function setVehicleModel(VehicleModel $model) {
        $this->_vehicleModel = $model;
    }

    public function setVehicleWorkshop(VehicleWorkshop $workshop) {
        $this->_vehicleWorkshop = $workshop;
    }

    public function getBrandModel() {
        if (is_null($this->_vehicleBrand)) {
            $this->_vehicleBrand = new VehicleBrand($this->brand_id);
        }
        if (is_null($this->_vehicleModel)) {
            $this->_vehicleModel = new VehicleModel($this->model_id);
        }
        return $this->_vehicleBrand->getName() . ' ' . $this->_vehicleModel->getName();
    }

    public function getVehicleWorkshop() {
        return $this->_vehicleWorkshop;
    }

    public function getEngineFuel() {
        return $this->engine . ' ' . $this->fuel;
    }

    public function getAlias() {
        return str_replace(' ', '-', strtolower($this->getBrandModel()));
    }

    public function getVehicleRefuel() {
        if ($this->_vehicleRefuel === null) {
            $vehicleRefuelRepository = new RepositoryVehicleRefuel($this->_database);
            $vehicleRefuelRepository->criteria(array('orderby' => array(VehicleRefuel::$_table_name . '.id', 'DESC'), 'where' => array('vehicle_id', $this->getId())))->paginate(1, 5)->getAll();
            $this->_vehicleRefuel = $vehicleRefuelRepository;
        }
        return $this->_vehicleRefuel;
    }
	
    public function getVehicleRefuelAll() {
        if ($this->_vehicleRefuel === null) {
            $vehicleRefuelRepository = new RepositoryVehicleRefuel($this->_database);
            $vehicleRefuelRepository->criteria(array('orderby' => array(VehicleRefuel::$_table_name . '.id', 'DESC'), 'where' => array('vehicle_id', $this->getId())))->getAll();
            $this->_vehicleRefuel = $vehicleRefuelRepository;
        }
        return $this->_vehicleRefuel;
    }
	
    public function getVehicleRepair($count = 5) {
        if ($this->_vehicleRepair === null) {
            $vehicleRepairRepository = new RepositoryVehicleRepair($this->_database);
            $vehicleRepairRepository->getRepairWorkshopList($count)->getAll();
            $this->_vehicleRepair = $vehicleRepairRepository;
        }
        return $this->_vehicleRepair;
    }	
    public function getPhotos() {
        if ($this->_vehicleGallery === null) {
            $vehicleGalleryRepository = new RepositoryVehicleGallery($this->_database);
			$vehicleGalleryRepository->criteria(array('orderby' => array(VehicleGallery::$_table_name . '.id', 'DESC'), 'where' => array('vehicle_id', $this->getId())))->getAll();
            $this->_vehicleGallery = $vehicleGalleryRepository;
        }
        return $this->_vehicleGallery;
    }

    public function __set1($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

	public function convertToArray() {
		$array = array();
		foreach (get_object_vars($this) as $key => $val) {
			if ($key[0]!="_") {
				$array[$key] = $val;
			}
        }
        if ($this->_vehicleRefuel !== null) {
			foreach ($this->_vehicleRefuel as $key => $vehicleRefuel) {
				$array['vehicleRefuel'][$key] = $vehicleRefuel->convertToArray();
			}
		}
		
		if ($this->_vehicleRepair !== null) {
			foreach ($this->_vehicleRepair as $key => $vehicleRepair) {
				$array['vehicleRepair'][$key] = $vehicleRepair->convertToArray();
			}
		}
		
		if ($this->_vehicleGallery !== null) {
			if (!is_array($this->_vehicleGallery)) {
				$this->_vehicleGallery = array($this->_vehicleGallery);
			}
			foreach ($this->_vehicleGallery as $key => $vehicleGallery) {
				$array['vehicleGallery'][$key] = $vehicleGallery->convertToArray();
			}
		}
		
		if ($this->_vehicleWorkshop !== null) {
			$array['vehicleWorkshop'] = $this->_vehicleWorkshop->convertToArray();
		}
		
		if ($this->_vehicleBrand !== null) {
			$array['vehicleBrand'] = $this->_vehicleBrand->convertToArray();
		}
		
		if ($this->_vehicleModel !== null) {
			$array['vehicleModel'] = $this->_vehicleModel->convertToArray();
		}
		return $array;
	}
}
