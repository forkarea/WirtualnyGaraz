<?php

namespace PioCMS\Controllers;

use PioCMS\Models\Repository\RepositoryUsers;

class Home extends Controller {

    public function index() {
        $this->view->setTitle(trans('homepage'));
        $this->view->header();
        $this->view->renderView('home/index');
        $this->view->footer();
    }

}
