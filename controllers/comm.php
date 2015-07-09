<?php

class comm extends controller {

    function __construct() {
        parent::__construct();
        session::init();
        session::loginAuth("comm");

        $this->breadcrumb->add("Commission", "comm");
    }

    function index() {
        $agent_id = $this->_userData['agent_id'];

        $monthList = $this->model->monthList();
        $this->view->monthList = $monthList;

        $this->view->commissionType = $this->model->getCommissionType();
        
        $this->view->getTotalCommission = user::getTotalCommission($agent_id);
        $this->view->getTotalPayout = user::getTotalPayout($agent_id);
        $this->view->getAvailPayout = user::getAvailableComm($agent_id);

        $this->view->pdiList = $this->model->totalCommission($agent_id, "pdi", $monthList);
        $this->view->gdiList = $this->model->totalCommission($agent_id, "gdi", $monthList);
        $this->view->gaiList = $this->model->totalCommission($agent_id, "gai", $monthList);
        $this->view->paiList = $this->model->totalCommission($agent_id, "pai", $monthList);
        $this->view->pbtList = $this->model->totalCommission($agent_id, "pbt", $monthList);
        $this->view->gbtList = $this->model->totalCommission($agent_id, "gbt", $monthList);
        $this->view->aprList = $this->model->totalCommission($agent_id, "apr", $monthList);

        $this->view->breadcrumbs = $this->breadcrumb->get();
        $this->view->js = array('comm/js/index.js');
        $this->view->render('comm/index', 'backoffice');
    }

    function commissionList() {
        $type = $_GET['ftype'];
        $month = $_GET['fmonth'];

        $this->model->commissionList($type, $month);
    }

    function reseller() {
        $monthList = $this->model->monthList(1);
        $this->view->monthList = $monthList;

        $this->breadcrumb->add("Reseller", "comm/reseller");
        $this->view->breadcrumbs = $this->breadcrumb->get();
        $this->view->js = array('comm/js/reseller.js');
        $this->view->render('comm/reseller', 'backoffice');
    }

    function sponsorship() {
        $monthList = $this->model->monthList(1);
        $this->view->monthList = $monthList;

        $this->breadcrumb->add("Sponsorship", "comm/sponsorship");
        $this->view->breadcrumbs = $this->breadcrumb->get();
        $this->view->js = array('comm/js/sponsorship.js');
        $this->view->render('comm/sponsorship', 'backoffice');
    }

    function spillover() {
        $monthList = $this->model->monthList(1);
        $this->view->monthList = $monthList;

        $this->breadcrumb->add("Spillover", "comm/spillover");
        $this->view->breadcrumbs = $this->breadcrumb->get();
        $this->view->js = array('comm/js/spillover.js');
        $this->view->render('comm/spillover', 'backoffice');
    }

    function passive_overriding() {
        $monthList = $this->model->monthList();
        $this->view->monthList = $monthList;

        $this->breadcrumb->add("Spillover", "comm/passive_overriding");
        $this->view->breadcrumbs = $this->breadcrumb->get();
        $this->view->js = array('comm/js/passive_overriding.js');
        $this->view->render('comm/passive_overriding', 'backoffice');
    }

    function withdrawal() {
        $monthList = $this->model->monthList(1);
        $this->view->monthList = $monthList;

        $agent_id = session::get(AGENT_SESSION_NAME);
        $this->view->bankDetails = user::getUserBank("agent_id", $agent_id);
        $this->view->bankList = user::getBanks();

        $this->breadcrumb->add("Withdrawal", "comm/withdrawal");
        $this->view->breadcrumbs = $this->breadcrumb->get();
        $this->view->js = array('comm/js/withdrawal.js');
        $this->view->render('comm/withdrawal', 'backoffice');
    }

    function withdrawal_exec() {
        $response_array = array();

        try {
            $form = new form();
            $form->post('agent_id')
                    ->post('bank_name')
                    ->val('Bank Name', 'minlength')
                    ->post('acc_no')
                    ->val('Account No.', 'digit')
                    ->post('holder_name')
                    ->val('Bank Holder Name', 'minlength')
                    ->post('amount')
                    ->val('Amount', 'minlength')
                    ->post('password')
                    ->val('Password', 'minlength')
                    ->post('date_request');

            $form->submit();

            $data = $form->fetch();

            $result = $this->model->withdrawal_exec($data);

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

    function cancelWithdraw() {
        $id = $_POST['id'];
        $this->model->cancelWithdraw($id);
    }

    function getWithdrawalStatement() {
        $agent_id = $this->_userData['agent_id'];
        $this->model->getWithdrawalStatement($agent_id);
    }

    function getCommissionStatement() {
        $agent_id = $this->_userData['agent_id'];
        $type = $_GET['type'];
        $this->model->getCommissionStatement($agent_id, $type);
    }

}
