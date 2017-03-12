<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\UserDevice;

class RepositoryUserDevice extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\UserDevice';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = UserDevice::$_table_name;
        $this->default_column = UserDevice::$_primary;
    }

}
