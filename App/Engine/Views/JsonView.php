<?php

namespace PioCMS\Engine\Views;

use PioCMS\Interfaces\ViewInterfaces;
use PioCMS\Engine\Session;
use PioCMS\Models\Repository\RepositoryUserDevice;

class JsonView implements ViewInterfaces {

    /** @var string */
    private $token;

    /** @var Session */
    private $session;

    /** @var Database */
    private $database;

    /** @var array */
    private $variable;

    // view type
    const VIEW_TYPE = "JSON";

    public function __construct($directory = NULL) {
        if ($this->variable === NULL) {
            $this->variable = array();
        }
        global $session, $database;
        $this->session = $session;
        $this->database = $database;

        $this->token = $directory;
    }

    public function footer() {
        
    }

    public function getTitle() {
        
    }

    public function header($header = NULL) {
        
    }

    public function renderView($view, array $data = NULL) {
        checkToken();
        if ($data !== NULL) {
            $this->variable = array_merge($this->variable, $data);
        }
    }

    public function setTitle($title) {
        
    }

    public function generate() {
        if (!isset($this->variable['error'])) {
            $this->variable['error'] = array('nr' => 0, 'error' => '');
        }
        $var = array();

        $var = convertObjectsToArray($this->variable);

        print json_encode($var);
        exit;
    }

    public function redirect($url, $code = 301) {
        $sessions = unserializedAll($this->session->getAll());
        if (isset($sessions['refuel_add_error'])) {
            unset($sessions['error']);
            $sessions['error'] = array('nr' => 101, 'error' => implode(",", $sessions['refuel_add_error']['error']));
            unset($sessions['refuel_add_error']);
        }
        $this->renderView(null, $sessions);
        $this->generate();
    }

    public function cssPush($fileName, $default) {
        
    }

    public function jsPush($fileName, $default) {
        
    }

    private function checkToken() {
        $userRepository = new RepositoryUserDevice($this->database);
        $userDevice = $userRepository->findByParams('token', $this->token);
        if ($userDevice !== NULL && $userDevice->getUserId()) {
            $date = date('Y-m-d H:i:s');
            $userDevice->setDate_login($date);
            $userDevice->update();
            $userInfo = new User($userDevice->getUserId());
            $userInfo->setDate_last_login($date);
            $userInfo->update();
            $session->put('user_id', $userInfo->getID());
        } else {
            $array['error'] = array('nr' => 100, 'error' => trans('login_error'));
            $this->renderView(null, $array);
            $this->generate();
        }
    }

}
