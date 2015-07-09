<?php

class home extends controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('index/home');
    }

}
