<?php

namespace PioCMS\Controllers;

use PioCMS\Models\Repository\RepositoryUsers;
use PioCMS\Engine\Language;
use PioCMS\Engine\Validator;
use PioCMS\Models\Auth;
use PioCMS\Models\User as UserInfo;
use PioCMS\Engine\View;
use PioCMS\Models\UserDevice;

class User extends Controller {

    protected $_userRepository;

    public function __construct($database, $session, $view) {
        $this->_session = $session;
        $this->_database = $database;
        $this->_view = $view;
        $this->_userRepository = new RepositoryUsers($this->_database);
    }

    public function index() {
        print 'index';
    }

    public function register() {
        if (Auth::isAuth()) {
            redirect(genereteURL('garage'));
        }
        $array = array();
        $info = $this->_session->get('register_error');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $array['form_url'] = genereteURL('user_register');
        $array['form_title'] = trans('register');
        $array['register'] = true;
        $this->_view->setTitle(Language::trans('register'));
        $this->_view->header();
        $this->_view->renderView('home/register', $array);
        $this->_view->footer();
    }

    public function register_form() {
        $required = array('first_name', 'mail', 'password', 'password_repeat');
        if (count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
            redirect(genereteURL('home'));
        }
        $v = new Validator($this->_database);
        $v->validate([
            'first_name' => [$_POST['first_name'], 'required'],
            'mail' => [$_POST['mail'], 'required|unique(users,mail)|email'],
            'password' => [$_POST['password'], 'required|matches(password_repeat)|min(5)|max(20)'],
            'password_repeat' => [$_POST['password_repeat'], 'required']
        ]);

        if ($v->passes()) {
            $user = new \PioCMS\Models\User;
            $_POST['password'] = hashPassword($_POST['password']);
            $user->loadFromArray($_POST);
            $id = $this->_userRepository->insert($user->convertToArray());
            $userInfo = $this->_userRepository->findByID($id);
            redirect(genereteURL('user_register_success'));
        } else {
            $array = $_POST;
            $array['error'] = $v->errors()->all();
            $this->_session->set('register_error', serialize($array));
            redirect(genereteURL('user_register'));
        }
    }

    public function register_form_gcm() {
        View::$_type = "xml";
        $required = array('first_name', 'mail', 'password', 'password_repeat');
        if (count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
            exit;
        }
        $v = new Validator($this->_database);
        $v->validate([
            'first_name' => [$_POST['first_name'], 'required'],
            'mail' => [$_POST['mail'], 'required|unique(users,mail)|email'],
            'password' => [$_POST['password'], 'required|matches(password_repeat)|min(5)|max(20)'],
            'password_repeat' => [$_POST['password_repeat'], 'required']
        ]);

        if ($v->passes()) {
            $user = new \PioCMS\Models\User;
            $_POST['password'] = hashPassword($_POST['password']);
            $user->loadFromArray($_POST);
            $id = $this->_userRepository->insert($user->convertToArray());
            $userInfo = $this->_userRepository->findByID($id);
        } else {
            $array['error'] = array('nr' => 101, 'error' => implode("\n", $v->errors()->all()));
        }
        $this->_view->renderView('home/register', $array);
        exit;
    }

    public function login() {
        if (Auth::isAuth()) {
            redirect(genereteURL('garage'));
        }
        $array = array();
        $info = $this->_session->get('login_error');
        $this->_session->put('login_error', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $this->_view->setTitle(Language::trans('login'));
        $this->_view->header();
        $this->_view->renderView('home/login', $array);
        $this->_view->footer();
    }

    public function login_form() {
        $required = array('mail', 'password');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            redirect(genereteURL('home'));
        }

        $v = new Validator($this->_database);
        $v->validate([
            'mail' => [$_POST['mail'], 'required|email'],
            'password' => [$_POST['password'], 'required']
        ]);

        $array = $_POST;
        if (!$v->passes()) {
            $array['error'] = $v->errors()->all();
            $this->_session->set('login_error', serialize($array));
            redirect(genereteURL('user_login'));
        }

        $userInfo = $this->_userRepository->findByParams('mail', $_POST['mail']);
        if ($userInfo->getID() > 0 && password_verify($_POST['password'], $userInfo->getPassword())) {
            $userInfo->setDate_last_login(date("Y-m-d H:i:s"));
            $this->_userRepository->update($userInfo->convertToArray());
            $this->_session->put('user_id', $userInfo->getID());
            redirect(genereteURL('garage'));
        } else {
            $array['error'] = array(trans('login_error_default'));
        }

        $this->_session->set('login_error', serialize($array));
        redirect(genereteURL('user_login'));
    }

	public function get_user_info() {
		if (!Auth::isAuth()) {
            redirect(genereteURL('user_login'));
        }

        $array['user']['id'] = Auth::getUserID();
		$this->_view->renderView('home/profile_edit', $array);
	}
    public function login_form_gcm() {
        View::$_type = "xml";
        $required = array('mail', 'password');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            exit;
        }

        $v = new Validator($this->_database);
        $v->validate([
            'mail' => [$_POST['mail'], 'required|email'],
            'password' => [$_POST['password'], 'required']
        ]);

        $array = $_POST;
        if (!$v->passes()) {
            $array['error'] = array('nr' => 101, 'error' => $v->errors()->all());
        }

        $userInfo = $this->_userRepository->findByParams('mail', $_POST['mail']);
        if ($userInfo->getID() > 0 && password_verify($_POST['password'], $userInfo->getPassword())) {
            $date_login = date("Y-m-d H:i:s");
            $userInfo->setDate_last_login($date_login);
			$userInfo->update();
            $userInfoArray = $userInfo->convertToArray();	
            unset($array);
            $array['user']['id'] = $userInfoArray['id'];

            $token = generateRandomString(50);
            $userDevice = new UserDevice();
            $userDevice->setUser_id($userInfo->getID());
            $userDevice->setDate_login($date_login);
            $userDevice->setToken($token);
            $userDevice->insert();
			$userDeviceArray = $userDevice->convertToArray();
            $array['userDevice']['token'] = $userDeviceArray['token'];
        } else {
            $array['error'] = array('nr' => 101, 'error' => 'podane dane sa nieprawidloswe');
        }

        $this->_view->renderView('home/login', $array);
        exit;
    }

    public function forgot() {
        $array = array();
        $info = $this->_session->get('forgot_form');
        $this->_session->put('forgot_form', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $this->_view->setTitle(trans('forgot_password'));
        $this->_view->header();
        $this->_view->renderView('home/forgot', $array);
        $this->_view->footer();
    }

    public function forgot_form() {
        $required = array('mail');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            redirect(genereteURL('home'));
        }
        $v = new Validator($this->_database);
        $v->validate([
            'mail' => [$_POST['mail'], 'required|exist(users,mail)|email'],
        ]);

        if ($v->passes()) {
            $user = new \PioCMS\Models\User;
            $userInfo = $this->_userRepository->findByParams('mail', $_POST['mail']);
            if ($userInfo->getID() > 0) {
                $passwordNew = generateRandomString(10);
                $userInfo->setPassword(hashPassword($passwordNew));
                try {
                    sendMail($_POST['mail'], trans('password_new'), str_replace('{password}', $passwordNew, trans('password_new_body')));
                    $array['succes'][] = trans('password_was_send');
                    $userInfo->update();
                } catch (\Exception $e) {
                    $array['error'][] = $e->getMessage();
                }
            } else {
                $array['error'][] = trans('mail_not_exist');
            }
        } else {
            $array = $_POST;
            $array['error'] = $v->errors()->all();
        }
        $this->_session->set('forgot_form', serialize($array));
        redirect(genereteURL('user_forgot_password'));
    }

    public function forgot_form_gcm() {
        View::$_type = "xml";
        $required = array('mail');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            exit;
        }
        $v = new Validator($this->_database);
        $v->validate([
            'mail' => [$_POST['mail'], 'required|exist(users,mail)|email'],
        ]);

        if ($v->passes()) {
            $user = new \PioCMS\Models\User;
            $userInfo = $this->_userRepository->findByParams('mail', $_POST['mail']);
            if ($userInfo->getID() > 0) {
                $passwordNew = generateRandomString(10);
                $userInfo->setPassword(hashPassword($passwordNew));
                try {
                    sendMail($_POST['mail'], trans('password_new'), str_replace('{password}', $passwordNew, trans('password_new_body')));
                    $array['succes'][] = trans('password_was_send');
                    $userInfo->update();
                } catch (\Exception $e) {
                    $array['error'][] = $e->getMessage();
                }
            } else {
                $array['error'] = array('nr' => 101, 'error' => trans('mail_not_exist'));
            }
        } else {
            $array['error'] = array('nr' => 101, 'error' => implode("\n", $v->errors()->all()));
        }
        $this->_view->renderView('home/forgot', $array);
        exit;
    }

    public function logout() {
        $this->_session->forget();
        redirect(genereteURL('home'));
    }

    public function profile_edit() {
        if (!Auth::isAuth()) {
            redirect(genereteURL('user_login'));
        }

        $user = new UserInfo(Auth::getUserID());
        $array = $user->convertToArray();
        $info = $this->_session->get('profile_edit');
        $this->_session->put('profile_edit', '');
        if (!empty($info)) {
            $array += unserialize($info);
        }

        $array['form_url'] = genereteURL('profile_edit');
        $array['form_title'] = trans('user_edit_profile');
        $this->_view->setTitle(Language::trans('user_edit_profile'));
        $this->_view->header();
        $this->_view->renderView('home/profile_edit', $array);
        $this->_view->footer();
    }

    public function profile_edit_form() {
        if (!Auth::isAuth()) {
            redirect(genereteURL('user_login'));
        }

        $required = array('first_name', 'mail', 'password', 'password_repeat');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            redirect(genereteURL('home'));
        }

        $user_id = Auth::getUserID();
        $v = new Validator($this->_database);
        $v->validate([
            'first_name' => [$_POST['first_name'], 'required'],
            'mail' => [$_POST['mail'], 'required|uniqueNotYours(users,mail,' . $user_id . ')|email'],
            'password' => [$_POST['password'], 'required|matches(password_repeat)|min(5)|max(20)'],
            'password_repeat' => [$_POST['password_repeat'], 'required']
        ]);

        if ($v->passes()) {
            $user = new \PioCMS\Models\User;
            $_POST['password'] = hashPassword($_POST['password']);
            $user->loadFromArray($_POST);
            $user->setID($user_id);
            $user->update();
            $array['succes'][] = trans('save_was_changes');
        } else {
            $array = $_POST;
            $array['error'] = $v->errors()->all();
        }
        $this->_session->set('profile_edit', serialize($array));
        redirect(genereteURL('profile_edit'));
    }

}
