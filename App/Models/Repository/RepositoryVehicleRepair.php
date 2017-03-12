<?php

namespace PioCMS\Models\Repository;

use PioCMS\Models\VehicleRepair;
use PioCMS\Models\VehicleWorkshop;

class RepositoryVehicleRepair extends Repository {

    protected $table_name;
    protected $default_column;
    protected $model = 'PioCMS\Models\VehicleRepair';

    public function __construct($_database) {
        parent::__construct($_database);
        $this->table_name = VehicleRepair::$_table_name;
        $this->default_column = VehicleRepair::$_primary;
    }

    public function getRepairWorkshopList($limit = 5) {
        $vehicleWorkshop = VehicleWorkshop::$_table_name;
        $joins = array(
            array(
                'model' => '\PioCMS\Models\VehicleWorkshop',
                'joinTable' => $vehicleWorkshop,
                'joinCondition' => $this->table_name . '.workshop_id=' . $vehicleWorkshop . '.id',
                'joinType' => 'INNER',
                'columns' => array($vehicleWorkshop . '.title vehicleWorkshop'),
                'conditions' => array('workshop_id' => 'id', 'vehicleWorkshop' => 'title'),
                'shortName' => '_vehicleWorkshop'
            )
        );
        $this->criteria(array('orderby' => array($this->table_name . '.id', 'DESC')));
        if ($limit != -1) {
			$this->paginate(1, $limit);
		}
        $this->join($joins);
        return $this;
    }

}
