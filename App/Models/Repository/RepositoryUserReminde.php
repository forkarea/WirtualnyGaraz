<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\UserReminde;

class RepositoryUserReminde extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\UserReminde';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->tableName = UserReminde::$tableName;
        $this->defaultColumn = UserReminde::$primary;
    }

}
