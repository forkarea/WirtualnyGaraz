<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\User;

class RepositoryUsers extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\User';

    public function __construct($database) {
        parent::__construct($database);
        $this->tableName = User::$tableName;
        $this->defaultColumn = User::$primary;
    }

}
