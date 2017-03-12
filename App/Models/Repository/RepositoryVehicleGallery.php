<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleGallery;

class RepositoryVehicleGallery extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\VehicleGallery';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = VehicleGallery::$_table_name;
        $this->default_column = VehicleGallery::$_primary;
    }

}
