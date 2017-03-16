<?php

namespace PioCMS;

use PioCMS\Engine\Router\Route;
use PioCMS\Engine\Router\Routes;
use PioCMS\Engine\URL;
use PioCMS\Interfaces\ViewInterfaces;

class Application {

    private $router;
    private $database;
    private $session;
    private $view;

    public function __construct($database, $session, $view) {
        $this->session = $session;
        $this->database = $database;
        $this->view = $view;
        Routes::init();
    }

    public function route() {
        foreach (Routes::$routes as $k => $v) {
            if (!empty($v->getName())) {
                URL::$routers[$v->getName()] = $v->getUri();
            }
            $this->router[$v->getMethod()][$v->getRoute()] = $v;
        }
    }

    public function render() {
        $find = false;
        $url = isset($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : isset($_GET['uri']) ? "/" . $_GET['uri'] : "/";

        foreach ($this->router[strtolower($_SERVER['REQUEST_METHOD'])] as $pattern => $callback) {
            $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
            if (preg_match($pattern, $url, $params)) {
                array_shift($params);
                $find = true;
                break;
            }
        }

        if (!$find) {
            $callback = $this->router['get']['/error_404'];
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
            $instance = new $classname($this->database, $this->session, $this->view);
        } else {
            $reflect = new \ReflectionClass($classname);
            $instance = $reflect->newInstance($this->database, $this->session, $this->view);
        }
        call_user_func_array(array($instance, $method_name), $params);
    }

    public function __destruct() {
        if ($this->view instanceof ViewInterfaces) {
            $this->view->generate();
        }
    }

}
