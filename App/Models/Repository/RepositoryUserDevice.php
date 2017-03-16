<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\UserDevice;

class RepositoryUserDevice extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\UserDevice';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->tableName = UserDevice::$tableName;
        $this->defaultColumn = UserDevice::$primary;
    }

}
