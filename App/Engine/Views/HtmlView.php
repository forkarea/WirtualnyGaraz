<?php

namespace PioCMS\Engine\Views;

use PioCMS\Interfaces\ViewInterfaces;
use PioCMS\Engine\Session;
use PioCMS\Engine\Language;
use PioCMS\Engine\URL;

class HtmlView implements ViewInterfaces {

    /** @var string */
    private $directory;

    /** @var string */
    private $title;

    /** @var string */
    private $defaultUrl;

    /** @var array */
    private $js;

    /** @var array */
    private $css;

    /** @var array */
    private $theme;

    /** @var array */
    private $variable;

    // view type
    const VIEW_TYPE = "html";

    public function __construct($directory = NULL) {
        if ($directory === NULL) {
            $directory = "default";
        }
        if ($this->js === NULL) {
            $this->js = array();
        }
        if ($this->css === NULL) {
            $this->css = array();
        }
        if ($this->theme === NULL) {
            $this->theme = array();
        }
        if ($this->variable === NULL) {
            $this->variable = array();
        }
        $this->setDirectory($directory);

        $this->setTitle(Language::trans('title'));
        $this->defaultUrl = HTTP_SERVER . DIRECTORY_SEPARATOR . 'template/' . $this->directory . DIRECTORY_SEPARATOR;
        array_push($this->js, $this->defaultUrl . 'js/jquery-1.11.3.min.js');
        array_push($this->js, $this->defaultUrl . 'js/jquery.main.js');
        array_push($this->js, $this->defaultUrl . 'js/plugins.js');
        array_push($this->css, $this->defaultUrl . 'css/bootstrap.css');
        array_push($this->css, $this->defaultUrl . 'css/font-awesome.min.css');
        array_push($this->css, $this->defaultUrl . 'css/page-assets.css');
        array_push($this->css, $this->defaultUrl . 'css/helper-elements.css');
        array_push($this->css, $this->defaultUrl . 'style.css');
        array_push($this->css, $this->defaultUrl . 'css/color/color.css');
        array_push($this->css, $this->defaultUrl . 'css/animate.css');
    }

    function getDirectory() {
        return $this->directory;
    }

    function setDirectory($directory) {
        $this->directory = $directory;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function jsPush($url, $default = false) {
        if ($default) {
            $url = $this->defaultUrl . $url;
        }
        array_push($this->js, $url);
    }

    public function cssPush($url, $default = false) {
        if ($default) {
            $url = $this->defaultUrl . $url;
        }
        array_push($this->css, $url);
    }

    public function footer() {
        $this->renderView('//footer');
    }

    public function header($header_style = NULL) {
        $this->renderView('//header', array('title' => $this->getTitle(), 'header_style' => $header_style));
    }

    public function renderView($view, array $data = NULL) {
        if (is_array($view)) {
            $view = implode('/', $view);
        }
        $file = DIR_TEMPLATE . $this->directory . DIRECTORY_SEPARATOR;
        $file .= substr($view, 0, 2) == '//' ? substr($view, 2) : strtolower($view);
        $file .= '.php';

        if (!file_exists($file)) {
            throw new \Exception(sprintf(trans('view_not_exist'), $view));
        }

        array_push($this->theme, $file);

        if ($data != null) {
            $this->variable = array_merge($this->variable, $data);
        }
    }

    public function generate() {
        $this->variable['default_url'] = $this->defaultUrl;
        $this->variable['_js'] = $this->js;
        $this->variable['_css'] = $this->css;
        if (count($this->variable) > 0) {
            extract($this->variable);
        }
        foreach ($this->theme as $file) {
            ob_start();
            include($file);
            $content = ob_get_contents();
            ob_end_clean();
            print $content;
        }
    }

    public function redirect($url, $code = 301) {
        return URL::redirect($url, $code);
    }

}
