<?php

namespace PioCMS\Models;

use PioCMS\Engine\Database;

abstract class Model {

    protected $_database;
    private $_table_name;
    private $_primary;
    private $id;

    public function __construct($id = null) {
        $this->_database = Database::getInstance();
        if ($this->_table_name !== null && $this->_primary !== null && $id > 0 && !is_null($id)) {
            $data = $this->_database->where($this->_primary, $id)->getOne($this->_table_name);
            if (is_array($data)) {
                $this->loadFromArray($data);
            }

            $this->id = $this->{$this->_primary};
        }
    }

    public function __clone() {
        
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function getTable_name() {
        return $this->_table_name;
    }

    public function getPrimaryKey() {
        return $this->_primary;
    }

    public function insert() {
        $data = $this->convertToArray();
        //if (!($data[$this->_primary] > 0)) {
//			unset($data[$this->_primary]);
        //}
        return $this->_database->insert($this->_table_name, $data);
    }

    public function delete() {
        $data = $this->convertToArray();
        if (!isset($data[$this->_primary]) || $data[$this->_primary] == 0) {
            throw new \Exception('primary key is empty');
        }
        $this->_database->where($this->_primary, $data[$this->_primary]);
        if ($this->_database->delete($this->_table_name)) {
            return true;
        } else {
            throw new \Exception($this->_database->getLastError());
        }
    }

    public function update() {
        $data = $this->convertToArray();
        if (!($data[$this->_primary] > 0)) {
            throw new \Exception('Primary key error');
        }
        $this->_database->where($this->_primary, $data[$this->_primary]);
        if ($this->_database->update($this->_table_name, $data)) {
            return $this->_database->count;
        } else {
            throw new \Exception($this->_database->getLastError());
        }
    }

}
