<?php

namespace PioCMS\Models;

use PioCMS\Interfaces\ModelInterfaces;
use PioCMS\Traits\ModelArrayConverter;

class VehicleGallery extends Model implements ModelInterfaces {

    public static $_table_name = 'vehicle_gallery';
    public static $_primary = 'id';
    private $id;
    private $vehicle_id;
    private $date_add;
    private $filename;
    private $path;
    private $ip;

    use ModelArrayConverter;

    public function __construct($id = null) {
        $this->_primary = self::$_primary;
        $this->_table_name = self::$_table_name;
		$this->date_add = date("Y-m-d H:i:s");
		$this->ip = ip2long(get_client_ip());
        parent::__construct($id);
    }

    function getId() {
        return $this->id;
    }

    function getVehicle_id() {
        return $this->vehicle_id;
    }

    function getDate_add() {
        return $this->date_add;
    }

    function getFilename() {
        return $this->filename;
    }

    function getPath() {
        return $this->path;
    }

    function getIp() {
        return $this->ip;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setVehicle_id($vehicle_id) {
        $this->vehicle_id = $vehicle_id;
    }

    function setDate_add($date_add) {
        $this->date_add = $date_add;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

}
