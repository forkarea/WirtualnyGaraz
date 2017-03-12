<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\UserAccountType;

class RepositoryUserAccountType extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\UserAccountType';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = UserAccountType::$_table_name;
        $this->default_column = UserAccountType::$_primary;
    }

}
