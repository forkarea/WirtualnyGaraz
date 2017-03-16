<?php

define('WEBSITE_NAME', getenv('WEBSITE_NAME'));
define('DEFAULT_REPLAY_TO', getenv('DEFAULT_REPLAY_TO'));
define('DEFAULT_MAIL', getenv('DEFAULT_MAIL'));
define('DATABASE_NAME', getenv('DATABASE_NAME'));
define('DATABASE_USER', getenv('DATABASE_USER'));
define('DATABASE_HOST', getenv('DATABASE_HOST'));
define('DATABASE_PASSOWD', getenv('DATABASE_PASSOWD'));
define('DIR_VENDOR', getenv('DIR_VENDOR'));
define('DIR_UPLOAD', getenv('DIR_UPLOAD'));
define('DIR_TEMPLATE', getenv('DIR_TEMPLATE'));
define('DIR_TEMPLATE_CACHE', getenv('DIR_TEMPLATE_CACHE'));

if (isset($_SERVER['HTTPS'])) {
    define('HTTP_SERVER', 'https://' . substr($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], 0, strrpos($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], '/')));
} else {
    define('HTTP_SERVER', 'http://' . substr($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], 0, strrpos($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], '/')));
}