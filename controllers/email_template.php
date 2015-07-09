<?php

class email_template extends controller {

    function __construct() {
        parent::__construct();
        $this->breadcrumb->add("Create New Account", "join");
    }

    function index() {
        $this->view->render('email/supplier_activation', NULL, false);
    }

    function activation() {
        $this->view->render('email/activation', NULL, false);
    }
    
    function activation_success() {
        $this->view->render('email/activation_success', NULL, false);
    }
    
    function payment_complete() {
        $this->view->render('email/payment_complete', NULL, false);
    }
    
    function payment_received() {
        $this->view->render('email/payment_received', NULL, false);
    }
    
    function message_received() {
        $this->view->render('email/message_received', NULL, false);
    }
    
    function contact() {
        $this->view->render('email/contact', NULL, false);
    }
    
    function news() {
        $this->view->render('email/news', NULL, false);
    }
    
    function supplier_activation() {
        $this->view->render('email/supplier_activation', NULL, false);
    }
    
    function supplier_activation_success() {
        $this->view->render('email/supplier_activation_success', NULL, false);
    }

}
