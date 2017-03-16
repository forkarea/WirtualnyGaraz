<?php

namespace PioCMS\Interfaces;

interface ModelInterfaces {

    public function setId($id);

    public function setHiddenVars($hiddenVars);

    public function setDateVars($dateVars);

    public function setTableName($tableName);

    public function setPrimaryKey($primaryKey);

    public function getId();

    public function getHiddenVars();

    public function getDateVars();

    public function getTableName();

    public function getPrimaryKey();

    public function loadFromArray($array);

    public function convertToArray();
}
