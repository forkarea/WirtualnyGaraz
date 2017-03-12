<?php

namespace PioCMS\Engine;

class URL {

    public static $routers = array();

    public static function genereteURL($route_name, $variables = null) {
        if (!isset(self::$routers[$route_name])) {
            throw new \Exception(sprintf(\PioCMS\Engine\Language::trans('router_not_exist'), $route_name));
        }

        $url = self::$routers[$route_name];
        if (!is_null($variables)) {
            if (is_array($variables)) {
                foreach ($variables as $key => $value) {
                    $url = str_replace("{{$key}}", $value, $url);
                }
            } else {
                $url = str_replace("{{$key}}", $value, $url);
            }
        }
        return HTTP_SERVER . $url;
    }

    public static function redirect($target, $code = 301) {
        flush();
        header("Location: " . $target, true, $code);
        echo "<html></html>";
        ob_flush();
        exit();
    }

}
