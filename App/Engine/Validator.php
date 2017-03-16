<?php

namespace PioCMS\Engine;

use Violin\Violin;

class Validator extends Violin {

    protected $database;

    public function __construct($db) {
        $this->database = $db;

        $this->addRuleMessage('unique', 'That {field} is taken.');
        $this->addRuleMessage('exist', 'That {field} not exist in our database');
        $this->addRuleMessage('equals', 'That {field} parametrs is not the same.');
        $this->addRuleMessage('price', 'The {field} field is not the numeric.');
        $this->addRuleMessage('uniqueNotYours', 'That {field} exist in our database');
    }

    public function validate_unique($value, $input, $args) {
        if (empty($args) || count($args) <> 2) {
            throw new \Exception('empty args');
        }
        $table_name = $args[0];
        $primary = $args[1];
        $count = $this->database->getValue($table_name, "count($primary)");
        return ($count == 0);
    }

    public function validate_exist($value, $input, $args) {
        if (empty($args) || count($args) <> 2) {
            throw new \Exception('empty args');
        }
        $table_name = $args[0];
        $primary = $args[1];
        $count = $this->database->getValue($table_name, "count($primary)");
        return ($count > 0);
    }

    public function validate_uniqueNotYours($value, $input, $args) {
        if (empty($args) || count($args) <> 3) {
            throw new \Exception('empty args');
        }
        $table_name = $args[0];
        $primary = $args[1];
        $id = $args[2];

        $record = $this->database->where($primary, $value)->getOne($table_name);
        if (count($record) > 0 && $record['id'] != $id) {
            return false;
        }
        return true;
    }

    public function validate_equals($value, $input, $args) {
        if (empty($args)) {
            throw new \Exception('empty args');
        }

        if (!isset($input[$args[0]])) {
            throw new \Exception('empty input');
        }
        return ($input[$args[0]] === $value);
    }

    public function validate_price($value, $input, $args) {
        if (!is_numeric($value)) {
            return false;
        }
        if ($value < 0) {
            return false;
        }

        if ($value !== number_format($value, 2, '.', '')) {
            return false;
        }

        return true;
    }

}
