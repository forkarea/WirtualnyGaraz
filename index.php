<?php

require 'vendor/autoload.php';
try {
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();
    $dotenv->required([
        'WEBSITE_NAME', 'DEFAULT_REPLAY_TO', 'DEFAULT_MAIL', 'DATABASE_NAME',
        'DATABASE_USER', 'DATABASE_HOST', 'DATABASE_PASSOWD', 'DIR_VENDOR',
        'DIR_UPLOAD', 'DIR_TEMPLATE', 'DIR_TEMPLATE_CACHE'
    ]);
    $dotenv->load();
} catch (\Exception $e) {
    print $e->getMessage();
}

require 'config.php';
require 'functions.php';

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

    $data = file_get_contents('php://input');
    $token = "";
    if (strlen($data) > 0) {
        $variables = json_decode($data, true);
        $token = isset($variables['token']) ? $variables['token'] : "";
    }
    $views = array(
        PioCMS\Engine\Views\HtmlView::VIEW_TYPE => new PioCMS\Engine\Views\HtmlView(),
        PioCMS\Engine\Views\JsonView::VIEW_TYPE => new PioCMS\Engine\Views\JsonView($token),
    );


    $view = $views[PioCMS\Engine\Views\HtmlView::VIEW_TYPE];
    if (strlen($token) > 0) {
        $view = $views[PioCMS\Engine\Views\JsonView::VIEW_TYPE];
    }


    $app = new PioCMS\Application($database, $session, $view);
    $app->route();
    $app->render();
} catch (\Exception $e) {
    print $e->getMessage();
}
