<?php

class plan extends controller {

    function __construct() {
        parent::__construct();
        $this->breadcrumb->add("The Plan", "plan");
        $this->view->breadcrumbs = $this->breadcrumb->get();
    }

    function index() {
        $this->view->render('plan/index');
    }

}
