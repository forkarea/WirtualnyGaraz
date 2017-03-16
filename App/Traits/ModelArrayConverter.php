<?php

namespace PioCMS\Traits;

trait ModelArrayConverter {

    public function convertToArray() {
        $array = array();
        if (!empty($this->getMapper())) {
            print 'asdsadsadsa';
            foreach ($this->getMapper() as $key => $val) {
                print $key . ' - ' . $val . '<br />';
                if (!in_array($key, $this->hiddenVars)) {
                    if (in_array($key, $this->dateVars)) {
                        $this->$key = \PioCMS\Models\Model::formatDateTime($this->$key);
                    }
                    $array[$val] = $this->$key;
                }
            }

            return $array;
        }
        foreach (get_object_vars($this) as $key => $val) {
            print $key . ' - ' . $val . '<br />';
            if (!in_array($key, $this->hiddenVars)) {
                if (in_array($key, $this->dateVars)) {
                    $val = \PioCMS\Models\Model::formatDateTime($val);
                }
                $array[$key] = $val;
            }
        }
        return $array;
    }

    public function loadFromArray($array) {
        if (empty($array)) {
            return;
        }
        if (!empty($this->getMapper())) {
            foreach ($this->getMapper() as $key => $val) {
                if (in_array($key, $this->dateVars)) {
                    $array[$val] = \PioCMS\Models\Model::createDateTime($array[$val]);
                }
                $this->$key = $array[$val];
            }
            return;
        }
        foreach (get_object_vars($this) as $key => $val) {
            if (isset($array[$key])) {
                if (!empty($this->dateVars) && in_array($key, $this->dateVars)) {
                    $array[$key] = \PioCMS\Models\Model::createDateTime($array[$key]);
                }
                $this->$key = $array[$key];
            }
        }
//        exit;
    }

}
