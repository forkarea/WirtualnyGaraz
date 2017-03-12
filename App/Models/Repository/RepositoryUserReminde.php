<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\UserReminde;

class RepositoryUserReminde extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\UserReminde';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = UserReminde::$_table_name;
        $this->default_column = UserReminde::$_primary;
    }

}
