<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\User;

class RepositoryUsers extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\User';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = User::$_table_name;
        $this->default_column = User::$_primary;
    }

}
