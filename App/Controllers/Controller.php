<?php

namespace PioCMS\Controllers;

use PioCMS\Interfaces\ViewInterfaces;
use PioCMS\Engine\Session;

abstract class Controller {

    protected $database;
    protected $session;
    protected $view;

    public function __construct($database, Session $session, ViewInterfaces $view) {
        $this->session = $session;
        $this->database = $database;
        $this->view = $view;
    }

    public function redirect($url, $code = 301) {
        if ($this->view instanceof ViewInterfaces) {
            $this->view->redirect($url, $code);
            return;
        }
        throw new \Exception('View must be instanceof ViewInterfaces');
    }

}
