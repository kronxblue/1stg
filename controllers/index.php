<?php

class index extends controller {

    function __construct() {
        parent::__construct();
        
    }

    function index() {
        $this->view->js = array('index/js/index.js');
        $this->view->render('index/index','default', FALSE);
    }
}
