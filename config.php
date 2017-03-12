<?php

define('WEBSITE_NAME', 'WirtualnyGaraz.pl');
define('DEFAULT_REPLAY_TO', 'adrian@pionka.com');
define('DEFAULT_MAIL', 'xxx@yyy.pl');
define('DATABASE_NAME', 'xxxxxxxxxxxx');
define('DATABASE_USER', 'xxxxxxxxxxxx');
define('DATABASE_HOST', 'localhost');
define('DATABASE_PASSOWD', 'xxxxxxxxxxxx');
define('DIR_VENDOR', '/home/pionas/wwww/vendor/');
define('DIR_UPLOAD', '/home/pionas/wwww/uploads/');
define('DIR_TEMPLATE', '/home/pionas/wwww/template/');
define('DIR_TEMPLATE_CACHE', '/home/pionas/wwww/cache/template/');
if (isset($_SERVER['HTTPS'])) {
    define('HTTP_SERVER', 'https://' . substr($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], 0, strrpos($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], '/')));
} else {
    define('HTTP_SERVER', 'http://' . substr($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], 0, strrpos($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], '/')));
}

function trans($name) {
    return \PioCMS\Engine\Language::trans($name);
}

function genereteURL($route_name, $variables = null) {
    return \PioCMS\Engine\URL::genereteURL($route_name, $variables);
}

function redirect($url, $code = 301) {
    return \PioCMS\Engine\URL::redirect($url, $code);
}

function hashPassword($passwod) {
    $cost = 10;
    return password_hash($passwod, PASSWORD_BCRYPT, ["cost" => $cost]);
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function arrayMap($elements, $ids, $new = false) {
    if (!isset($elements[0])) {
        $elements = array($elements);
    }

    $arrayNew = array();
    if (!$new) {
        $arrayNew = $elements;
    }
    foreach ($ids as $key => $val) {
        for ($i = 0, $total = count($elements); $i < $total; $i++) {
            if (isset($elements[$i][$key])) {
                $arrayNew[$i][$ids[$key]] = $elements[$i][$key];
                unset($arrayNew[$i][$key]);
            }
        }
    }
    return $arrayNew;
}

function convertCurrency($currency) {
    $currency = str_replace(',', '.', $currency);
    if (!is_numeric($currency)) {
        return '0.00';
    }
    return number_format($currency, 2, '.', '');
}

function sendMail($receiver, $title, $message) {
    $mail = new \PHPMailer;
    //$mail->isSMTP();                                      // Set mailer to use SMTP
    //$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
    //$mail->SMTPAuth = true;                               // Enable SMTP authentication
    //$mail->Username = 'user@example.com';                 // SMTP username
    //$mail->Password = 'secret';                           // SMTP password
    //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    //$mail->Port = 587;                                    // TCP port to connect to
    $mail->addAddress($receiver);               // Name is optional
    $mail->addReplyTo(DEFAULT_REPLAY_TO);
    $mail->isHTML(false);                                  // Set email format to HTML
    $mail->Subject = $title;
    $mail->Body = $message;

    if (!$mail->send()) {
        throw new \Exception($mail->ErrorInfo);
    } else {
        return true;
    }
}

function convertObjectsToArray($objects) {
    $arrays = array();
    foreach ($objects as $k => $v) {
        if (is_object($v)) {
            $arrays[$k] = $v->convertToArray();
        } elseif (is_array($v)) {
            if (isset($v[1])) {
                $arrays[$k][] = convertObjectsToArray($v);
            } else {
                $arrays[$k] = convertObjectsToArray($v);
            }
        } else {
            $arrays[$k] = $v;
        }
    }
    return $arrays;
}

function unserializedAll($string) {
    $arrays = array();
    foreach ($string as $k => $v) {
        if (is_array($v)) {
            $arrays[$k] = unserializedAll($v);
        } else {
            $data = @unserialize($v);
            if ($data !== false) {
                $arrays[$k] = $data;
            } else {
                $arrays[$k] = $v;
            }
        }
    }
    return $arrays;
}

function isXML() {
    return (\PioCMS\Engine\View::$_type == "xml");
}
