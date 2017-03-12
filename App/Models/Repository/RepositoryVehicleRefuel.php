<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleRefuel;

class RepositoryVehicleRefuel extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\VehicleRefuel';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = VehicleRefuel::$_table_name;
        $this->default_column = VehicleRefuel::$_primary;
    }

}
