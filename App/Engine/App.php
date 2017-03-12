<?php

namespace PioCMS\Engine;

use PioCMS\Models\Repository\RepositoryUserDevice;
use PioCMS\Models\User;
use PioCMS\Engine\View;

class App {

    public static function init() {
        global $session, $database, $view;

        $data = file_get_contents('php://input');
		
        if (isset($_POST) && !empty($_POST)) {
            $data = "";
        }
        if (strlen($data) == 0) {
            return;
        }
		$_POST = json_decode($data, true);
        $token = isset($_POST['token']) ? $_POST['token'] : "";

        if (strlen($token) == 0) {
            return;
        }
        View::$_type = "xml";
        $_userRepository = new RepositoryUserDevice($database);
        $date = date('Y-m-d H:i:s');
        $userDevice = $_userRepository->findByParams('token', $token);
        if ($userDevice->getUser_id()) {
            $userDevice->setDate_login($date);
            $userDevice->update();
            $userInfo = new User($userDevice->getUser_id());
            $userInfo->setDate_last_login($date);
            $userInfo->update();
            $session->put('user_id', $userInfo->getID());
        } else {
			$array['error'] = array('nr' => 100, 'error' => trans('login_error'));
			$view->renderView('home/login', $array);
		}
    }

}
