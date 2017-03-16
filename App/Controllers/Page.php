<?php

namespace PioCMS\Controllers;

class Page extends Controller {

    public function error_404() {
        $this->view->setTitle(trans('error_404_header'));
        $this->view->header();
        $this->view->renderView('home/static/error_404');
        $this->view->footer();
    }

}
