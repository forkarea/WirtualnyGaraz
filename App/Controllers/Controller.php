<?php

namespace PioCMS\Controllers;

use PioCMS\Engine\URL;
use PioCMS\Engine\View;

abstract class Controller {

    protected $_database;
    protected $_session;
    protected $_view;

    public function __construct($database, $session, $view) {
        $this->_session = $session;
        $this->_database = $database;
        $this->_view = $view;
    }

    public function redirect($url, $code = 301) {
        if (View::$_type == "xml") {
            $sessions = unserializedAll($this->_session->getAll());
            if (isset($sessions['refuel_add_error'])) {
                unset($sessions['error']);
                $sessions['error'] = array('nr' => 101, 'error' => implode(",", $sessions['refuel_add_error']['error']));
                unset($sessions['refuel_add_error']);
            }
            $this->_view->renderView('home/garage/vehicle_add', $sessions);
            exit;
        }
        return URL::redirect($url, $code);
    }

}
