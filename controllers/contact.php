<?php

class contact extends controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->js = array('index/js/contact.js');
        $this->view->render('index/contact');
    }
    
    function exec() {
        $response_array = array();

        try {
            $form = new form();
            $form   ->post('name')
                    ->val('Name', 'minlength')
                    ->post('email')
                    ->val('Email', 'email')
                    ->post('phone')
                    ->post('message')
                    ->val('Message', 'minlength');

            $form->submit();

            $data = $form->fetch();

            $result = $this->model->exec($data);

            if ($result['r'] == 'true') {
                $response_array['r'] = $result['r'];
                $response_array['msg'] = $result['msg'];
            } else {
                $response_array['r'] = $result['r'];
                $response_array['msg'] = $result['msg'];
            }
        } catch (Exception $e) {

            $response_array['r'] = 'false';
            $response_array['msg'] = $e->getMessage();
        }

        echo json_encode($response_array);
    }

}
