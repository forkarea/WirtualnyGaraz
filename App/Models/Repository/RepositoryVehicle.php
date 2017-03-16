<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\Vehicle;
use PioCMS\Models\VehicleBrand;
use PioCMS\Models\VehicleModel;
use PioCMS\Models\VehicleGallery;
use PioCMS\Interfaces\SearchCriteriaInterfaces;

class RepositoryVehicle extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\Vehicle';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->tableName = Vehicle::$tableName;
        $this->defaultColumn = Vehicle::$primary;
    }

    public function getVehicleList($user_id = NULL) {
        $vehicleBrand = VehicleBrand::$tableName;
        $vehicleModel = VehicleModel::$tableName;
        $vehicleGallery = VehicleGallery::$tableName;

        $joins = array(
            array(
                'model' => '\PioCMS\Models\VehicleBrand',
                'joinTable' => $vehicleBrand,
                'joinCondition' => $this->tableName . '.brand_id=' . $vehicleBrand . '.id',
                'joinType' => 'INNER',
                'columns' => array($vehicleBrand . '.name vehicleBrand'),
                'conditions' => array('brand_id' => 'id', 'vehicleBrand' => 'name'),
                'shortName' => 'vehicleBrand'
            ),
            array(
                'model' => '\PioCMS\Models\VehicleModel',
                'joinTable' => $vehicleModel,
                'joinCondition' => $this->tableName . '.model_id=' . $vehicleModel . '.id',
                'joinType' => 'INNER',
                'columns' => array($vehicleModel . '.name vehicleModel'),
                'conditions' => array('model_id' => 'id', 'vehicleModel' => 'name'),
                'shortName' => 'vehicleModel'
            ),
            array(
                'model' => '\PioCMS\Models\VehicleGallery',
                'joinTable' => $vehicleGallery,
                'joinCondition' => $this->tableName . '.id=' . $vehicleGallery . '.vehicle_id',
                'joinType' => 'LEFT',
                'columns' => array($vehicleGallery . '.filename photoFilename', $vehicleGallery . '.path photoPath', $vehicleGallery . '.vehicle_id photoVehicleID', $vehicleGallery . '.id photoID'),
                'conditions' => array('photoPath' => 'path', 'photoFilename' => 'filename', 'photoVehicleID' => 'vehicleId', 'photoID' => 'id'),
                'shortName' => 'vehicleGallery'
            )
        );
        $this->criteria(array('orderby' => array($this->tableName . '.id', 'DESC'), 'group' => array($this->tableName . '.id')));
        if ($user_id != NULL) {
            $this->findByParams($this->tableName . '.user_id', $user_id);
        }
        $this->join($joins);
        return $this;
    }

    public function find(SearchCriteriaInterfaces $searchCriteriaInterfaces) {
        
    }

}
