<?php

namespace PioCMS\Models;

use PioCMS\Engine\Database;
use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Interfaces\DateTimeInterfaces;

abstract class Model implements ModelInterfaces, DateTimeInterfaces {

    /** @var Database */
    protected $database;

    /** @var string */
    private $tableName;

    /** @var string */
    public $primaryKey;

    /** @var int */
    public $id;

    /** @var array */
    public $hiddenVars;

    /** @var array */
    public $dateVars;

    /** @var array */
    public $mapper;

    public function __construct($id = null) {
        $this->database = Database::getInstance();
        if ($this->tableName !== null && $this->primaryKey !== null && $id > 0 && !is_null($id)) {
            $data = $this->database->where($this->primaryKey, $id)->getOne($this->tableName);
            if (is_array($data)) {
                $this->loadFromArray($data);
            }

            $this->id = $this->{$this->primaryKey};
        }
        if ($this->getHiddenVars() === null) {
            $this->setHiddenVars(array(
                'tableName', 'primary', 'database', 'hiddenVars',
                'dateVars', 'mapper'
            ));
        }
    }

    public function __clone() {
        
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function insert() {
        $data = $this->convertToArray();
        return $this->database->insert($this->tableName, $data);
    }

    public function delete() {
        $data = $this->convertToArray();
        if (!isset($data[$this->primaryKey]) || $data[$this->primaryKey] == 0) {
            throw new \Exception('primary key is empty');
        }
        $this->database->where($this->primaryKey, $data[$this->primaryKey]);
        if ($this->database->delete($this->tableName)) {
            return true;
        } else {
            throw new \Exception($this->database->getLastError());
        }
    }

    public function update() {
        $data = $this->convertToArray();
        if (!($data[$this->primaryKey] > 0)) {
            throw new \Exception('Primary key error');
        }
        $this->database->where($this->primaryKey, $data[$this->primaryKey]);
        if ($this->database->update($this->tableName, $data)) {
            return $this->database->count;
        } else {
            throw new \Exception($this->database->getLastError());
        }
    }

    public function createDateTime($input) {
        return \DateTime::createFromFormat('Y-n-j H:i:s', $input);
    }

    public function formatDateTime(\DateTime $date) {
        return $date->format('Y-m-d H:i:s');
    }

    function getTableName() {
        return $this->tableName;
    }

    function getPrimaryKey() {
        return $this->primaryKey;
    }

    function getId() {
        return $this->id;
    }

    function getHiddenVars() {
        return $this->hiddenVars;
    }

    function getDateVars() {
        return $this->dateVars;
    }

    function getMapper() {
        return $this->mapper;
    }

    function setTableName($tableName) {
        $this->tableName = $tableName;
    }

    function setPrimaryKey($primaryKey) {
        $this->primaryKey = $primaryKey;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setHiddenVars($hiddenVars) {
        $this->hiddenVars = $hiddenVars;
    }

    function setDateVars($dateVars) {
        $this->dateVars = $dateVars;
    }

    function setMapper($mapper) {
        $this->mapper = $mapper;
    }

}
