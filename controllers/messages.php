<?php

class messages extends controller {

    function __construct() {
        parent::__construct();
        session::init();
        session::loginAuth("messages");

        $this->breadcrumb->add("Commission", "comm");
    }

    function index() {
        $agent_id = $this->_userData['agent_id'];

        $this->view->breadcrumbs = $this->breadcrumb->get();
        $this->view->js = array('comm/js/index.js');
        $this->view->render('comm/index', 'backoffice');
    }

    function getMessagesList() {

        $agent_id = session::get(AGENT_SESSION_NAME);

        $data = $this->model->getMessagesList($agent_id);

        $count = count($data);

        $result = "";

        if ($count > 0) {
            foreach ($data as $key => $value) {
                $type = $value['type'];

                if ($type == "email") {
                    $image = IMAGES_PATH . "user-default.png";
                    $from = $value['name'] . " [" . $value['from'] . "]";
                } else {
                    
                }

                $result .= $from;
            }
        } else {
            $result .= "<p class='text-center'>You have no messages.</p>";
        }



        echo json_encode($result);
    }

}
