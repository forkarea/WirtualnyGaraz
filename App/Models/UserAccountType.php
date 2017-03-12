<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;

class UserAccountType extends Model implements ModelInterfaces {

    public static $_table_name = 'user_account_type';
    public static $_primary = 'id';
    private $id;
    private $name;

    use ModelArrayConverter;

    public function __construct($id = null) {
        $this->_primary = self::$_primary;
        $this->_table_name = self::$_table_name;
        parent::__construct($id);
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

}
