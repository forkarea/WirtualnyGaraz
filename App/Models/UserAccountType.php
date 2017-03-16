<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;

class UserAccountType extends Model implements ModelInterfaces {

    public static $tableName = 'user_account_type';
    public static $primary = 'id';

    /** @var string */
    private $name;

    use ModelArrayConverter;

    public function __construct($id = null) {
        parent::__construct($id);
        parent::setTableName(self::$tableName);
        parent::setPrimaryKey(self::$primary);
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

}
