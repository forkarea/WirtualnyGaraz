<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleWorkshop;

class RepositoryWorkshop extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\VehicleWorkshop';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = VehicleWorkshop::$_table_name;
        $this->default_column = VehicleWorkshop::$_primary;
    }

}
