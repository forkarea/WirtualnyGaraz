<?php

namespace PioCMS\Models\Repository;

use PioCMS\Interfaces\ModelRepositoryInterfaces;

abstract class Repository implements ModelRepositoryInterfaces {

    protected $_database;
    private $_count = 0;
    private $_totalPages = 0;
    private $_criteria = array();
    private $_joins = array();
    private $_columns = array();
    private $_data = array();

    public function __construct($_database) {
        $this->_database = $_database;
    }

    /**
     * Variable that holds limit records for paginate
     *
     * @var array
     */
    private $paginate = array();

    public function getTotalPages() {
        return $this->_totalPages;
    }

    public function getData() {
        return $this->_data;
    }

    public function criteria(array $_criteria) {
        $this->_criteria = $_criteria;
        return $this;
    }

    public function convertToArray(array $objects) {
        if (!is_array($objects)) {
            throw new \Exception("to nie jest tablica");
        }
        $array = array();
        $i = 0;
        foreach ($objects as $object) {
            if ($object instanceof \stdClass) {
                $array[$i++] = json_decode(json_encode($object), true);
            } else {
                $array[$i++] = $object->convertToArray();
            }
        }
        return $array;
    }

    public function loadFromArray() {
        return $this->convertToArray($this->_data);
    }

    public function checkCritera() {
        if (!is_null($this->_criteria)) {
            foreach ($this->_criteria as $key => $value) {
                switch ($key) {
                    case "where":
                        if (count($value) == 2) {
                            $this->_database->where($value[0], $value[1]);
                        }
                        break;

                    case "orderby":
                        if (count($value) == 2) {
                            $this->_database->orderBy($value[0], $value[1]);
                        }
                        break;

                    case "primaryDesc":
                        $this->_database->orderBy($this->default_column, 'DESC');
                        break;

                    case "primaryAsc":
                        $this->_database->orderBy($this->default_column, 'ASC');
                        break;
						
                    case "group":
						if (count($value) > 0) {
                        $this->_database->groupBy($value[0]);
						}
                        break;
						
						
                }
            }
        }
        $this->checkJoin();
    }

    public function checkJoin() {
        if (!is_null($this->_joins)) {
            foreach ($this->_joins as $key => $value) {
                $this->_database->join($value['joinTable'], $value['joinCondition'], $value['joinType']);
            }
        }
    }

    public function limit($limit) {
        $this->paginate = $limit;
        return $this;
    }

    public function count() {
        if (is_null($this->table_name) || is_null($this->default_column)) {
            throw new \Exception(\PioCMS\Engine\Language::trans('table_name'));
        }
        $this->checkCritera();
		$column_name = (isset($this->_criteria['group'])) ? 'DISTINCT ' : '';
		$column_name = $column_name.$this->table_name.'.'.$this->default_column;
        $this->_count = $this->_database->getValue($this->table_name, "count($column_name)");
        return $this;
    }

    public function getCount() {
        return $this->_count;
    }

    public function findByID($id) {
        if (!is_null($this->default_column)) {
            return $this->findByParams($this->default_column, $id);
        }
        return new \stdClass();
    }

    public function findByParams($params, $value) {
        if (!is_array($params) && !is_array($value)) {
            $params = array($params);
            $value = array($value);
        }
        if (!is_null($this->table_name) && !empty($params) && !empty($value) && !is_null($this->model) && class_exists($this->model)) {
            foreach ($params as $k => $v) {
                $this->_database->where($params[$k], $value[$k]);
            }
            $record = $this->_database->getOne($this->table_name);
            $object = new $this->model();
            $object->loadFromArray($record);
            return $object;
        }
        return new \stdClass();
    }

    public function getAll() {
        if (!is_null($this->table_name) && !is_null($this->default_column) && !is_null($this->model) && class_exists($this->model)) {
            $this->checkCritera();
            $columns = '*';
            if (count($this->_columns) > 0) {
                $columns = $this->table_name . '.*, ' . implode(', ', $this->_columns);
            }
            $records = $this->_database->get($this->table_name, (empty($this->paginate) ? NULL : $this->paginate), $columns);
            $objects = array();
            foreach ($records as $record) {
                $object = new $this->model();
                $object->loadFromArray($record);
                $this->loadJoins($object, $record);
                $objects[] = $object;
            }
            $this->_data = $objects;
            return $this;
        }
        throw new \Exception(sprintf(\PioCMS\Engine\Language::trans('model_not_exist'), $this->model));
    }

    private function loadJoins(&$object, $record) {
        if (!is_null($this->_joins)) {
            foreach ($this->_joins as $key => $value) {
                $helper = new $value['model'];
                $array = array();
                foreach ($value['conditions'] as $k => $v) {
                    $array[$v] = $record[$k];
                }
                $helper->loadFromArray($array);

                $object->$value['shortName'] = $helper;
            }
        }
    }

    public function paginate($page, $limit = 20) {
        if (is_null($this->table_name)) {
            throw new \Exception(\PioCMS\Engine\Language::trans('table_name'));
        }

        $this->count();
        $offset = $limit * ($page - 1);
        $this->paginate = array($offset, $limit);

        $this->_totalPages = ceil($this->_count / $limit);
        return $this;
    }

    public function insert(array $data) {
        return $this->_database->insert($this->table_name, $data);
    }

    public function update(array $data) {
        return $this->_database->update($this->table_name, $data);
    }

    public function join($array) {
        if (!isset($array[0])) {
            $array = array($array);
        }
        foreach ($array as $key => $val) {
            $this->_joins[] = array('joinTable' => $val['joinTable'], 'joinCondition' => $val['joinCondition'], 'joinType' => $val['joinType'], 'conditions' => $val['conditions'], 'model' => $val['model'], 'shortName' => $val['shortName']);
            if (empty($val['columns'])) {
                $this->_columns[] = $val['joinTable'] . '.*';
            } else {
                $this->_columns[] = implode(',', $val['columns']);
            }
        }

        return $this;
    }

}
