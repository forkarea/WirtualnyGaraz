<?php

require 'config.php';
require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');  //On or Off
try {
    $database = new PioCMS\Engine\Database(DATABASE_HOST, DATABASE_USER, DATABASE_PASSOWD, DATABASE_NAME);
    $database->rawQuery('SET NAMES "utf8"');
	
    $session = new PioCMS\Engine\Session('cheese');
    ini_set('session.save_handler', 'files');
    session_set_save_handler($session, true);
    session_save_path(__DIR__ . '/sessions');
    $session->start();
    if (!$session->isValid(5)) {
        $session->forget();
    }

    $view = new PioCMS\Engine\View();
	
    $app = new PioCMS\Application($database, $session, $view);
    $app->route();
    $app->render();
} catch (Exception $e) {
    print $e->getMessage();
}
