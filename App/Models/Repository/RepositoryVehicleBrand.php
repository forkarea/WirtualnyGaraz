<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleBrand;

class RepositoryVehicleBrand extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\VehicleBrand';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = VehicleBrand::$_table_name;
        $this->default_column = VehicleBrand::$_primary;
    }

}
