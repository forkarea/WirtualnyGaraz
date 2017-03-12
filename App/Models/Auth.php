<?php

namespace PioCMS\Models;

class Auth {

    public static function isAuth() {
        global $session;
        $user_id = $session->get('user_id');
        return (intval(abs($user_id)) > 0);
    }

    public static function getUserID() {
        global $session;
        $user_id = $session->get('user_id');
        return intval(abs($user_id));
    }

}

?>