<?php

namespace PioCMS\Interfaces;

interface DatabaseInterfaces {

    public function getInstance();

    public function save();

    public function insert();

    public function update();

    public function delete();

    public function getAll();

    public function getById($id);

    public function find(SearchCriteria $searchCriteria);
}
