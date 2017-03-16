<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleWorkshop;

class RepositoryWorkshop extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\VehicleWorkshop';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->tableName = VehicleWorkshop::$_table_name;
        $this->defaultColumn = VehicleWorkshop::$_primary;
    }

}
