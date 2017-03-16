<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\UserAccountType;

class RepositoryUserAccountType extends Repository {

    protected $tableName;
    protected $defaultColumn;
    protected $model = 'PioCMS\Models\UserAccountType';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->tableName = UserAccountType::$tableName;
        $this->defaultColumn = UserAccountType::$primary;
    }

}
