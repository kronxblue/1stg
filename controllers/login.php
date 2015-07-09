<?php

class login extends controller {

    function __construct() {
        parent::__construct();
        session::loginAuth("login");
    }

    function index() {
        $this->view->js = array('login/js/index.js');
        $this->view->render('login/index');
    }

    function exec() {
        $response_array = array();

        try {
            $form = new form();
            $form->post('username')
                    ->val('Username', 'minlength')
                    ->post('password')
                    ->val('Password', 'minlength');

            $form->submit();

            if (isset($_POST['rememberme'])) {
                $form->post('rememberme');

                $form->submit();
            }

            $data = $form->fetch();

            $result = $this->model->login_exec($data);

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

    function forgotPass() {
        $response_array = array();

        try {
            $form = new form();
            $form->post('email')
                    ->val('Email', 'email');

            $form->submit();

            $data = $form->fetch();

            $result = $this->model->forgotPass_exec($data);

            $response_array['r'] = $result['r'];
            $response_array['msg'] = $result['msg'];
            
        } catch (Exception $e) {

            $response_array['r'] = 'false';
            $response_array['msg'] = $e->getMessage();
        }

        echo json_encode($response_array);
    }

}
