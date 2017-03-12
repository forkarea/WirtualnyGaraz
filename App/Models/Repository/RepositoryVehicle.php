<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\Vehicle;
use PioCMS\Models\VehicleBrand;
use PioCMS\Models\VehicleModel;
use PioCMS\Models\VehicleGallery;

class RepositoryVehicle extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\Vehicle';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = Vehicle::$_table_name;
        $this->default_column = Vehicle::$_primary;
    }

    public function getVehicleList() {
        $vehicleBrand = VehicleBrand::$_table_name;
        $vehicleModel = VehicleModel::$_table_name;
		$vehicleGallery = VehicleGallery::$_table_name;
		
        $joins = array(
            array(
                'model' => '\PioCMS\Models\VehicleBrand',
                'joinTable' => $vehicleBrand,
                'joinCondition' => $this->table_name . '.brand_id=' . $vehicleBrand . '.id',
                'joinType' => 'INNER',
                'columns' => array($vehicleBrand . '.name vehicleBrand'),
                'conditions' => array('brand_id' => 'id', 'vehicleBrand' => 'name'),
                'shortName' => '_vehicleBrand'
            ),
            array(
                'model' => '\PioCMS\Models\VehicleModel',
                'joinTable' => $vehicleModel,
                'joinCondition' => $this->table_name . '.model_id=' . $vehicleModel . '.id',
                'joinType' => 'INNER',
                'columns' => array($vehicleModel . '.name vehicleModel'),
                'conditions' => array('model_id' => 'id', 'vehicleModel' => 'name'),
                'shortName' => '_vehicleModel'
            ),
            array(
                'model' => '\PioCMS\Models\VehicleGallery',
                'joinTable' => $vehicleGallery,
                'joinCondition' => $this->table_name . '.id=' . $vehicleGallery . '.vehicle_id',
                'joinType' => 'LEFT',
                'columns' => array($vehicleGallery . '.filename photoFilename', $vehicleGallery . '.path photoPath', $vehicleGallery . '.vehicle_id photoVehicleID', $vehicleGallery . '.id photoID'),
                'conditions' => array('photoPath' => 'path', 'photoFilename' => 'filename', 'photoVehicleID' => 'vehicle_id', 'photoID' => 'id'),
                'shortName' => '_vehicleGallery'
            )
        );
        $this->criteria(array('orderby' => array($this->table_name . '.id', 'DESC'), 'group' => array($this->table_name . '.id')));
        $this->join($joins);
        return $this;
    }

}
