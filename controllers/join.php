<?php

class join extends controller {

    function __construct() {
        parent::__construct();
        $this->breadcrumb->add("Create New Account", "join");
    }

    function index() {

        $this->view->js = array('join/js/index.js');

        $referer = $this->model->getReferer();
        $this->view->referer = $referer;

        if ($referer != FALSE) {

            $refererData = $this->model->getRefererData($referer);
            $refererAcc = user::getAccType($refererData['acc_type']);

            $this->view->refererData = array(
                "username" => $refererData['username'],
                "accType" => $refererAcc['label']
            );
        }

        $this->view->accTypeList = user::getAccType();
        $this->view->breadcrumbs = $this->breadcrumb->get();

        $this->view->render('join/index');
    }

    function chkUsername() {
        $username = $_POST['username'];

        $chkUsername = $this->model->chkUsername($username);

        echo json_encode($chkUsername);
    }

    function exec() {
        $response_array = array();

        try {
            $form = new form();
            $form->post('salutation')
                    ->val('Salutation', 'minlength')
                    ->post('fullname')
                    ->val('Fullname', 'minlength')
                    ->post('username')
                    ->val('Username', 'minlength')
                    ->post('dob')
                    ->val('Date Of Birth', 'minlength')
                    ->post('email')
                    ->val('Email', 'minlength')
                    ->post('cemail')
                    ->val('Confirm Email', 'minlength')
                    ->post('acc_type')
                    ->val('Account Type', 'minlength')
                    ->post('subscribe')
                    ->post('chkusername')
                    ->post('dt_join')
                    ->post('sponsor_id')
		    ->val('Refferal ID', 'minlength');

            $form->submit();

            $data = $form->fetch();

            $result = $this->model->join_exec($data);

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

    function success($agent_id = NULL) {
        $this->breadcrumb->add("Successful", "join/success");
        $this->view->breadcrumbs = $this->breadcrumb->get();

        if (isset($agent_id)) {
            $verify = user::checkExist("user_accounts", "agent_id = '$agent_id'");

            if (!$verify) {
                redirect::to();
                exit();
            } else {

                $data = user::getUserData("agent_id", $agent_id);
                $this->view->userdata = $data;

                $this->view->js = array('join/js/success.js');
                $this->view->render('join/success');
            }
        } else {
            redirect::to();
            exit();
        }
    }

    function request_activation() {
        $this->breadcrumb->add("Request Activation", "join/success");
        $this->view->breadcrumbs = $this->breadcrumb->get();
        $this->view->js = array('join/js/request_activation.js');
        $this->view->render('join/request_activation');
    }

    function resend_activation() {

        $email = $_POST['email'];

        $data = user::getUserData('email', $email);
        if ($data != FALSE) {
            $result = $this->model->resend_activation($data);
        } else {
            $result = FALSE;
        }


        echo json_encode($result);
    }

    function verify() {
        $this->view->js = array('join/js/verify.js');
        $this->view->render('join/verify');
    }

    function verify_check() {

        $code = $_POST['code'];
        $salt = $_POST['salt'];

        $userData = user::getUserData('username', $salt);

        $salt = user::generateActivationCode($userData['email']);

        $verify = $this->model->verify($salt, $code, $userData);
//        $verify = TRUE;

        echo json_encode($verify);
    }

    function verify_failed() {
        $this->breadcrumb->add("Email Verification", "join/verify_failed");
        $this->view->breadcrumbs = $this->breadcrumb->get();

        $this->view->render('join/verify_failed');
    }

    function verify_success() {
        $this->breadcrumb->add("Email Verification", "join/verify_success");
        $this->view->breadcrumbs = $this->breadcrumb->get();

        if (isset($_GET['u'])) {
            $username = $_GET['u'];

            $this->view->userdata = user::getUserData('username', $username);

            $this->view->js = array('join/js/verify_success.js');
            $this->view->render('join/verify_success');
        } else {
            redirect::to();
        }
    }

    function resend_details() {

        $email = $_POST['email'];
        $result = $this->model->resend_details($email);

        echo json_encode($result);
    }

}
