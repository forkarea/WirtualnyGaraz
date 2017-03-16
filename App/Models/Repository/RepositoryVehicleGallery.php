<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleGallery;

class RepositoryVehicleGallery extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\VehicleGallery';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->tableName = VehicleGallery::$tableName;
        $this->defaultColumn = VehicleGallery::$primary;
    }

}
