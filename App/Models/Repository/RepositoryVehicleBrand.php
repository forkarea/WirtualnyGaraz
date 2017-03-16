<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleBrand;

class RepositoryVehicleBrand extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\VehicleBrand';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->tableName = VehicleBrand::$tableName;
        $this->defaultColumn = VehicleBrand::$primary;
    }

}
