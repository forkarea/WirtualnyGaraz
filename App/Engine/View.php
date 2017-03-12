<?php

namespace PioCMS\Engine;

class View {

    private $directory = 'default';
    private $title;
    private $_default_url;
    private $_js = array();
    private $_css = array();
    private $_theme = array();
    private $_footer = '';
    private $_header = '';
    private $_variable = array();
    public static $_type = 'html';

    public function __construct($directory = null) {
        if (!is_null($directory)) {
            $this->directory = $directory;
        }

        $this->setTitle(Language::trans('title'));
        $this->_default_url = HTTP_SERVER . DIRECTORY_SEPARATOR . 'template/' . $this->directory . DIRECTORY_SEPARATOR;
        array_push($this->_js, $this->_default_url . 'js/jquery-1.11.3.min.js');
        array_push($this->_js, $this->_default_url . 'js/jquery.main.js');
        array_push($this->_js, $this->_default_url . 'js/plugins.js');
        array_push($this->_css, $this->_default_url . 'css/bootstrap.css');
        array_push($this->_css, $this->_default_url . 'css/font-awesome.min.css');
        array_push($this->_css, $this->_default_url . 'css/page-assets.css');
        array_push($this->_css, $this->_default_url . 'css/helper-elements.css');
        array_push($this->_css, $this->_default_url . 'style.css');
        array_push($this->_css, $this->_default_url . 'css/color/color.css');
        array_push($this->_css, $this->_default_url . 'css/animate.css');
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function jsPush($url, $default = false) {
        if ($default) {
            $url = $this->_default_url . $url;
        }
        array_push($this->_js, $url);
    }

    public function cssPush($url, $default = false) {
        if ($default) {
            $url = $this->_default_url . $url;
        }
        array_push($this->_css, $url);
    }

    public function header($header_style = 'style23') {
        $this->renderView('//header', array('title' => $this->getTitle(), 'header_style' => $header_style));
    }

    public function footer() {
        $this->renderView('//footer');
    }

    public function renderView($view, array $data = null) {
        if (is_array($view)) {
            $view = implode('/', $view);
        }
        $file = DIR_TEMPLATE . $this->directory . DIRECTORY_SEPARATOR;
        $file .= substr($view, 0, 2) == '//' ? substr($view, 2) : strtolower($view);
        $file .= '.php';

        if (!file_exists($file)) {
            throw new \Exception(sprintf(trans('view_not_exist'), $view));
        }

        array_push($this->_theme, $file);

        if ($data != null) {
            $this->_variable = array_merge($this->_variable, $data);
        }
    }

    public function __destruct() {
        $this->_variable['default_url'] = $this->_default_url;
        $this->_variable['_js'] = $this->_js;
        $this->_variable['_css'] = $this->_css;


        switch (self::$_type) {
            case "xml":
                if (!isset($this->_variable['error'])) {
                    $this->_variable['error'] = array('nr' => 0, 'error' => '');
                }
                unset($this->_variable['default_url']);
                unset($this->_variable['title']);
                unset($this->_variable['header_style']);
                unset($this->_variable['_js']);
                unset($this->_variable['_css']);
                $var = array();

                $var = convertObjectsToArray($this->_variable);

                print '';
                print json_encode($var);
                break;
            default:
                if (count($this->_variable) > 0) {
                    extract($this->_variable);
                }
                foreach ($this->_theme as $file) {
                    ob_start();
                    include($file);
                    $content = ob_get_contents();
                    ob_end_clean();
                    print $content;
                }
                break;
        }
    }

}
