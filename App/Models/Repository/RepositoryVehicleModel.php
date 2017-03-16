<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleModel;

class RepositoryVehicleModel extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\VehicleModel';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->tableName = VehicleModel::$tableName;
        $this->defaultColumn = VehicleModel::$primary;
    }

}
