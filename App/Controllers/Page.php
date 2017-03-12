<?php

namespace PioCMS\Controllers;

class Page extends Controller {

    public function error_404() {
        $this->_view->setTitle(trans('error_404_header'));
        $this->_view->header();
        $this->_view->renderView('home/static/error_404');
        $this->_view->footer();
    }

}
