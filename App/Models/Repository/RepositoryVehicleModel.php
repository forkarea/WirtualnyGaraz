<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleModel;

class RepositoryVehicleModel extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\VehicleModel';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = VehicleModel::$_table_name;
        $this->default_column = VehicleModel::$_primary;
    }

}
