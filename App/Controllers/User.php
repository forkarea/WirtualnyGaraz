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

    protected $userRepository;

    public function __construct($database, $session, $view) {
        $this->session = $session;
        $this->database = $database;
        $this->view = $view;
        $this->userRepository = new RepositoryUsers($this->database);
    }

    public function index() {
        print 'index';
    }

    public function register() {
        if (Auth::isAuth()) {
            $this->redirect(genereteURL('garage'));
        }
        $array = array();
        $info = $this->session->get('register_error');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $array['form_url'] = genereteURL('user_register');
        $array['form_title'] = trans('register');
        $array['register'] = true;
        $this->view->setTitle(Language::trans('register'));
        $this->view->header();
        $this->view->renderView('home/register', $array);
        $this->view->footer();
    }

    public function register_form() {
        $required = array('first_name', 'mail', 'password', 'password_repeat');
        if (count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
            $this->redirect(genereteURL('home'));
        }
        $v = new Validator($this->database);
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
            $id = $this->userRepository->insert($user->convertToArray());
            $userInfo = $this->userRepository->findByID($id);
            $this->redirect(genereteURL('user_register_success'));
        } else {
            $array = $_POST;
            $array['error'] = $v->errors()->all();
            $this->session->set('register_error', serialize($array));
            $this->redirect(genereteURL('user_register'));
        }
    }

    public function register_form_gcm() {
        $required = array('first_name', 'mail', 'password', 'password_repeat');
        if (count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
            exit;
        }
        $v = new Validator($this->database);
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
            $id = $this->userRepository->insert($user->convertToArray());
            $userInfo = $this->userRepository->findByID($id);
        } else {
            $array['error'] = array('nr' => 101, 'error' => implode("\n", $v->errors()->all()));
        }
        $this->view->renderView('home/register', $array);
        exit;
    }

    public function login() {
        if (Auth::isAuth()) {
            $this->redirect(genereteURL('garage'));
        }
        $array = array();
        $info = $this->session->get('login_error');
        $this->session->put('login_error', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $this->view->setTitle(Language::trans('login'));
        $this->view->header();
        $this->view->renderView('home/login', $array);
        $this->view->footer();
    }

    public function login_form() {
        $required = array('mail', 'password');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            $this->redirect(genereteURL('home'));
        }

        $v = new Validator($this->database);
        $v->validate([
            'mail' => [$_POST['mail'], 'required|email'],
            'password' => [$_POST['password'], 'required']
        ]);

        $array = $_POST;
        if (!$v->passes()) {
            $array['error'] = $v->errors()->all();
            $this->session->set('login_error', serialize($array));
            $this->redirect(genereteURL('user_login'));
        }

        $userInfo = $this->userRepository->findByParams('mail', $_POST['mail']);
        if ($userInfo->getID() > 0 && password_verify($_POST['password'], $userInfo->getPassword())) {
            $now = new \DateTime();
            $userInfo->setDateLastLogin($now);
            $this->userRepository->update($userInfo->convertToArray());
            $this->session->put('user_id', $userInfo->getID());
            $this->redirect(genereteURL('garage'));
        } else {
            $array['error'] = array(trans('login_error_default'));
        }

        $this->session->set('login_error', serialize($array));
        $this->redirect(genereteURL('user_login'));
    }

    public function get_user_info() {
        if (!Auth::isAuth()) {
            $this->redirect(genereteURL('user_login'));
        }

        $array['user']['id'] = Auth::getUserID();
        $this->view->renderView('home/profile_edit', $array);
    }

    public function login_form_gcm() {
        $required = array('mail', 'password');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            exit;
        }

        $v = new Validator($this->database);
        $v->validate([
            'mail' => [$_POST['mail'], 'required|email'],
            'password' => [$_POST['password'], 'required']
        ]);

        $array = $_POST;
        if (!$v->passes()) {
            $array['error'] = array('nr' => 101, 'error' => $v->errors()->all());
        }

        $userInfo = $this->userRepository->findByParams('mail', $_POST['mail']);
        if ($userInfo->getID() > 0 && password_verify($_POST['password'], $userInfo->getPassword())) {
            $now = new \DateTime();
            $userInfo->setDateLastLogin($now);
            $userInfo->update();
            $userInfoArray = $userInfo->convertToArray();
            unset($array);
            $array['user']['id'] = $userInfoArray['id'];

            $token = generateRandomString(50);
            $userDevice = new UserDevice();
            $userDevice->setUserId($userInfo->getID());
            $userDevice->setDateLogin($now);
            $userDevice->setToken($token);
            $userDevice->insert();
            $userDeviceArray = $userDevice->convertToArray();
            $array['userDevice']['token'] = $userDeviceArray['token'];
        } else {
            $array['error'] = array('nr' => 101, 'error' => 'podane dane sa nieprawidloswe');
        }

        $this->view->renderView('home/login', $array);
        exit;
    }

    public function forgot() {
        $array = array();
        $info = $this->session->get('forgot_form');
        $this->session->put('forgot_form', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $this->view->setTitle(trans('forgot_password'));
        $this->view->header();
        $this->view->renderView('home/forgot', $array);
        $this->view->footer();
    }

    public function forgot_form() {
        $required = array('mail');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            $this->redirect(genereteURL('home'));
        }
        $v = new Validator($this->database);
        $v->validate([
            'mail' => [$_POST['mail'], 'required|exist(users,mail)|email'],
        ]);

        if ($v->passes()) {
            $user = new \PioCMS\Models\User;
            $userInfo = $this->userRepository->findByParams('mail', $_POST['mail']);
            if ($userInfo->getID() > 0) {
                $passwordNew = generateRandomString(10);
                $userInfo->setPassword(hashPassword($passwordNew));
                try {
                    $userInfo->update();
                    sendMail($_POST['mail'], trans('password_new'), str_replace('{password}', $passwordNew, trans('password_new_body')));
                    $array['succes'][] = trans('password_was_send');
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
        $this->session->set('forgot_form', serialize($array));
        $this->redirect(genereteURL('user_forgot_password'));
    }

    public function forgot_form_gcm() {
        $required = array('mail');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            exit;
        }
        $v = new Validator($this->database);
        $v->validate([
            'mail' => [$_POST['mail'], 'required|exist(users,mail)|email'],
        ]);

        if ($v->passes()) {
            $user = new \PioCMS\Models\User;
            $userInfo = $this->userRepository->findByParams('mail', $_POST['mail']);
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
        $this->view->renderView('home/forgot', $array);
        exit;
    }

    public function logout() {
        $this->session->forget();
        $this->redirect(genereteURL('home'));
    }

    public function profile_edit() {
        if (!Auth::isAuth()) {
            $this->redirect(genereteURL('user_login'));
        }

        $user = new UserInfo(Auth::getUserID());
        $array = $user->convertToArray();
        $info = $this->session->get('profile_edit');
        $this->session->put('profile_edit', '');
        if (!empty($info)) {
            $array += unserialize($info);
        }

        $array['form_url'] = genereteURL('profile_edit');
        $array['form_title'] = trans('user_edit_profile');
        $this->view->setTitle(Language::trans('user_edit_profile'));
        $this->view->header();
        $this->view->renderView('home/profile_edit', $array);
        $this->view->footer();
    }

    public function profile_edit_form() {
        if (!Auth::isAuth()) {
            $this->redirect(genereteURL('user_login'));
        }

        $required = array('first_name', 'mail', 'password', 'password_repeat');
        if (count(array_intersect_key(array_flip($required), $_POST)) <> count($required)) {
            $this->redirect(genereteURL('home'));
        }

        $user_id = Auth::getUserID();
        $v = new Validator($this->database);
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
        $this->session->set('profile_edit', serialize($array));
        $this->redirect(genereteURL('profile_edit'));
    }

}
