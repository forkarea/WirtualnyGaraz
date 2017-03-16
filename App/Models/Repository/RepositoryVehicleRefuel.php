<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleRefuel;

class RepositoryVehicleRefuel extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\VehicleRefuel';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->tableName = VehicleRefuel::$tableName;
        $this->defaultColumn = VehicleRefuel::$primary;
    }

}
