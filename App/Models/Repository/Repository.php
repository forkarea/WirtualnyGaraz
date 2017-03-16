<?php

namespace PioCMS\Models\Repository;

use PioCMS\Interfaces\ModelRepositoryInterfaces;

abstract class Repository implements ModelRepositoryInterfaces {

    protected $database;
    private $count;
    private $totalPages;
    private $criteria;
    private $joins;
    private $columns;
    private $data;

    public function __construct($_database) {
        $this->database = $_database;
        $this->count = 0;
        $this->totalPages = 0;
        $this->criteria = array();
        $this->joins = array();
        $this->columns = array();
        $this->data = array();
    }

    /**
     * Variable that holds limit records for paginate
     *
     * @var array
     */
    private $paginate = array();

    public function getTotalPages() {
        return $this->totalPages;
    }

    public function getData() {
        return $this->data;
    }

    public function criteria(array $_criteria) {
        $this->criteria = $_criteria;
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
        return $this->convertToArray($this->data);
    }

    public function checkCritera() {
        if (!is_null($this->criteria)) {
            foreach ($this->criteria as $key => $value) {
                switch ($key) {
                    case "where":
                        if (count($value) == 2) {
                            $this->database->where($value[0], $value[1]);
                        }
                        break;

                    case "orderby":
                        if (count($value) == 2) {
                            $this->database->orderBy($value[0], $value[1]);
                        }
                        break;

                    case "primaryDesc":
                        $this->database->orderBy($this->defaultColumn, 'DESC');
                        break;

                    case "primaryAsc":
                        $this->database->orderBy($this->defaultColumn, 'ASC');
                        break;

                    case "group":
                        if (count($value) > 0) {
                            $this->database->groupBy($value[0]);
                        }
                        break;
                }
            }
        }
        $this->checkJoin();
    }

    public function checkJoin() {
        if (!is_null($this->joins)) {
            foreach ($this->joins as $key => $value) {
                $this->database->join($value['joinTable'], $value['joinCondition'], $value['joinType']);
            }
        }
    }

    public function limit($limit) {
        $this->paginate = $limit;
        return $this;
    }

    public function count() {
        if (is_null($this->tableName) || is_null($this->defaultColumn)) {
            throw new \Exception(\PioCMS\Engine\Language::trans('table_name'));
        }
        $this->checkCritera();
        $column_name = (isset($this->criteria['group'])) ? 'DISTINCT ' : '';
        $column_name = $column_name . $this->tableName . '.' . $this->defaultColumn;
        $this->count = $this->database->getValue($this->tableName, "count($column_name)");
        return $this;
    }

    public function getCount() {
        return $this->count;
    }

    public function findByID($id) {
        if (!is_null($this->defaultColumn)) {
            return $this->findByParams($this->defaultColumn, $id);
        }
        return new \stdClass();
    }

    public function findByParams($params, $value) {
        if (!is_array($params) && !is_array($value)) {
            $params = array($params);
            $value = array($value);
        }
        if (!is_null($this->tableName) && !empty($params) && !empty($value) && !is_null($this->model) && class_exists($this->model)) {
            foreach ($params as $k => $v) {
                $this->database->where($params[$k], $value[$k]);
            }
            $record = $this->database->getOne($this->tableName);
            $object = new $this->model();
            $object->loadFromArray($record);
            return $object;
        }
        return new \stdClass();
    }
    
    public function getAll() {
        if (!is_null($this->tableName) && !is_null($this->defaultColumn) && !is_null($this->model) && class_exists($this->model)) {
            $this->checkCritera();
            $columns = '*';
            if (count($this->columns) > 0) {
                $columns = $this->tableName . '.*, ' . implode(', ', $this->columns);
            }
            $records = $this->database->get($this->tableName, (empty($this->paginate) ? NULL : $this->paginate), $columns);
            $objects = array();
            foreach ($records as $record) {
                $object = new $this->model();
                $object->loadFromArray($record);
                $this->loadJoins($object, $record);
                $objects[] = $object;
            }
            $this->data = $objects;
            return $this;
        }

        throw new \Exception(sprintf(\PioCMS\Engine\Language::trans('model_not_exist'), $this->model));
    }

    private function loadJoins(&$object, $record) {
        if (!is_null($this->joins)) {
            foreach ($this->joins as $key => $value) {
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
        if (is_null($this->tableName)) {
            throw new \Exception(\PioCMS\Engine\Language::trans('table_name'));
        }

        $this->count();
        $offset = $limit * ($page - 1);
        $this->paginate = array($offset, $limit);

        $this->totalPages = ceil($this->count / $limit);
        return $this;
    }

    public function insert(array $data) {
        return $this->database->insert($this->tableName, $data);
    }

    public function update(array $data) {
        return $this->database->update($this->tableName, $data);
    }

    public function join($array) {
        if (!isset($array[0])) {
            $array = array($array);
        }
        foreach ($array as $key => $val) {
            $this->joins[] = array('joinTable' => $val['joinTable'], 'joinCondition' => $val['joinCondition'], 'joinType' => $val['joinType'], 'conditions' => $val['conditions'], 'model' => $val['model'], 'shortName' => $val['shortName']);
            if (empty($val['columns'])) {
                $this->columns[] = $val['joinTable'] . '.*';
            } else {
                $this->columns[] = implode(',', $val['columns']);
            }
        }

        return $this;
    }

}
