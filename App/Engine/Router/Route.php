<?php

namespace PioCMS\Engine\Router;

class Route {

    private $uri;
    private $method;
    private $controllerName;
    private $methodName;
    private $callback;
    private $name;
    private $route;

    public function __construct($method, $uri, $actions) {
        array_push(Routes::$routes, $this);
        $this->setUri($uri);
        $this->setRoute($uri);
        $this->setMethod($method);
        $this->explodeAction($actions);
        return $this;
    }

    public function explodeAction($actions) {
        if (!is_array($actions)) {
            $this->setCallback($actions);
            return;
        }
        if (isset($actions['name'])) {
            $this->setName($actions['name']);
        }
        if (isset($actions['uses'])) {
            list($ctrl, $method) = explode('@', $actions['uses']);
            if (empty($method)) {
                die('brakuje metody');
            }
            $this->setControllerName($ctrl);
            $this->setMethodName($method);
        }
    }

    public function where($name, $expression) {
        $this->route = str_replace("{{$name}}", "($expression)", $this->route);
        $this->route = str_replace("//", "/", $this->route);
        return $this;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getControllerName() {
        return $this->controllerName;
    }

    public function getMethodName() {
        return $this->methodName;
    }

    public function getCallback() {
        return $this->callback;
    }

    public function getName() {
        return $this->name;
    }

    public function getRoute() {
        return $this->route;
    }

    public function setUri($uri) {
        $this->uri = $uri;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function setControllerName($controllerName) {
        $this->controllerName = $controllerName;
    }

    public function setMethodName($methodName) {
        $this->methodName = $methodName;
    }

    public function setCallback($callback) {
        $this->callback = $callback;
    }

    public function setName($name) {
        $this->name = trim($name, '/');
    }

    public function setRoute($route) {
        $this->route = $route;
    }

}
