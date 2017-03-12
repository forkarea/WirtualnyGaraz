<?php

namespace PioCMS;

use PioCMS\Engine\Router\Route;
use PioCMS\Engine\Router\Routes;
use PioCMS\Engine\URL;
use PioCMS\Engine\App;

class Application {

    private $_router = array();
    private $_database;
    private $_session;
    private $_view;

    public function __construct($database, $session, $view) {
        $this->_session = $session;
        $this->_database = $database;
        $this->_view = $view;
        Routes::init();
        App::init();
    }

    public function route() {
        foreach (Routes::$routes as $k => $v) {
            if (!empty($v->getName())) {
                URL::$routers[$v->getName()] = $v->getUri();
            }
            $this->_router[$v->getMethod()][HTTP_SERVER . $v->getRoute()] = $v;
        }
    }

    public function render() {
        $find = false;
        $url = $_SERVER['SCRIPT_URI'];

        foreach ($this->_router[strtolower($_SERVER['REQUEST_METHOD'])] as $pattern => $callback) {
            $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
            if (preg_match($pattern, $url, $params)) {
                array_shift($params);
                $find = true;
                break;
            }
        }

        if (!$find) {
            $callback = $this->_router['get'][HTTP_SERVER . '/error_404'];
        }
        if (!is_null($callback->getCallback())) {
            return call_user_func_array($callback->getCallback(), array_values($params));
        }

        $classname = __NAMESPACE__ . '\Controllers\\' . ucfirst($callback->getControllerName());
        $method_name = $callback->getMethodName();
        if (!class_exists($classname)) {
            throw new \Exception("Class " . $classname . " not exists");
        }

        if (version_compare(phpversion(), '5.6.0', '>=')) {
            $instance = new $classname($this->_database, $this->_session, $this->_view);
        } else {
            $reflect = new \ReflectionClass($classname);
            $instance = $reflect->newInstance($this->_database, $this->_session, $this->_view);
        }

//        $classMethod = new \ReflectionMethod($classname, $method_name);
//        $argumentCount = count($classMethod->getParameters());
//        if (count($params) <> $argumentCount) {
//            throw new \Exception("Nieodpowiednia liczba parametrów");
//        }
        call_user_func_array(array($instance, $method_name), $params);
    }

}
