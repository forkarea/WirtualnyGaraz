<?php

namespace PioCMS\Interfaces;

interface ViewInterfaces {

    public function __construct($directory = NULL);

    public function setTitle($title);

    public function getTitle();

    public function header($header_style = NULL);

    public function renderView($view, array $data = NULL);

    public function footer();

    public function generate();

    public function redirect($url, $code = 301);

    public function jsPush($fileName, $default);

    public function cssPush($fileName, $default);
}
