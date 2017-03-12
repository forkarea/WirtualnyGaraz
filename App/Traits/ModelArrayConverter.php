<?php

namespace PioCMS\Traits;

trait ModelArrayConverter {
	
    public function convertToArray() {
        foreach (get_object_vars($this) as $key => $val) {
			if ($key[0]!="_") {
				$array[$key] = $val;
			}
        }
        return $array;
    }
	
    public function convertToArray2() {
        foreach (get_object_vars($this) as $key => $val) {
            $array[$key] = $val;
        }
        return $array;
    }

    public function loadFromArray($array) {
        if (empty($array)) {
            return;
        }
        foreach (get_object_vars($this) as $key => $val) {
            if (isset($array[$key])) {
                $this->$key = $array[$key];
            }
        }
    }

    public function convertToArray1() {
		$array = array();
		$reflect = new \ReflectionClass($this);
		$props   = $reflect->getProperties();
        foreach ($props as $key => $val) {
			if ($val->name[0]!="_") {
				$array[$val->name] = $this->{$val->name};
			}
        }
    }

    public function loadFromArray1($array) {
        if (empty($array)) {
            return;
        }
		
		$reflect = new \ReflectionClass($this);
		//$props   = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PRIVATE);
        foreach ($props as $key => $val) {
            if (isset($array[$val->name])) {
                $this->{$val->name} = $array[$val->name];
            }
        }
		
    }
	
}