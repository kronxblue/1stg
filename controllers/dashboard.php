<?php

class dashboard extends controller {

    function __construct() {
        parent::__construct();
        session::init();
        session::loginAuth("dashboard");
        
        $this->breadcrumb->add("Dashboard", "dashboard");
    }

    function index() {
        $agent_id = session::get(AGENT_SESSION_NAME);
        
        $this->view->reminder = $this->model->reminder();
        $this->view->totalEarning = user::getTotalCommission($agent_id);
        $this->view->totalAgentSponsor = $this->model->totalAgentSponsor();
        $this->view->totalPinSold = $this->model->totalPinSold($agent_id);
	
        
        $this->view->breadcrumbs = $this->breadcrumb->get();
        $this->view->js = array('dashboard/js/index.js');
        $this->view->render('dashboard/index', 'backoffice');
    }
    
    function topSponsor(){
        $data = $this->model->topSponsor();
        
        echo json_encode($data);
    }

    function logout() {
        $agent_id = session::get(AGENT_SESSION_NAME);
        user::logout($agent_id);
    }

}
