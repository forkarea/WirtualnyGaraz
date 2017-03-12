<?php

namespace PioCMS\Controllers;

use PioCMS\Models\Repository\RepositoryUsers;

class Home extends Controller {

    public function index() {
        $this->_view->setTitle(trans('homepage'));
        $this->_view->header();
        $this->_view->renderView('home/index');
        $this->_view->footer();
    }

}
