<?php

namespace PioCMS\Interfaces;

interface ModelRepositoryInterfaces {

//    public function find(SearchCriteriaInterfaces $searchCriteriaInterfaces);

    public function findByID($id);

    public function getAll();
}
