<?php

class management extends controller {

	private $user;

	function __construct() {
		parent::__construct();
		session::init();
		session::loginAuth("management");

		$this->breadcrumb->add("Management", "management");

		$this->user = user::getUserData('agent_id', session::get(AGENT_SESSION_NAME));
	}

	function index() {
		$this->view->breadcrumbs = $this->breadcrumb->get();

		$this->view->userlists = $this->model->userlists();
		$this->view->paymentlists = $this->model->paymentlists();
		$this->view->ss = user::generateActivationCode('avin_segar@yahoo.com');

		$this->view->js = array('management/js/index.js');
		$this->view->render('management/index', 'backoffice', false);
	}

	function payment() {
		$this->breadcrumb->add("Payment", "management/payment");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/payment.js');
		$this->view->render('management/payment', 'backoffice');
	}

	function withdrawal() {
		$this->view->pendingCount = user::countBadge("user_withdrawal", "status = '0'");

		$this->breadcrumb->add("Withdrawal", "management/withdrawal");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/withdrawal.js');
		$this->view->render('management/withdrawal', 'backoffice');
	}

	function getWaitingPayment() {
		$this->model->getWaitingPayment();
	}

	function getSummaryPayment() {
		$this->model->getSummaryPayment();
	}

	function payment_review() {

		$get_agent = isset($_REQUEST['agent_id']) ? $_GET['agent_id'] : FALSE;
		$get_id = isset($_REQUEST['i']) ? $_GET['i'] : FALSE;

		if ((!$get_agent) or ( !$get_id)) {
			redirect::to("management/payment");
		} else {
			$agentExist = user::checkExist("user_accounts", "agent_id = '$get_agent'");
			$paymentExist = user::checkExist("user_payment", "id = '$get_id' AND agent_id = '$get_agent'");

			if (!$agentExist or ! $paymentExist) {
				redirect::to("management/payment");
			}
		}

		$this->view->paymentDetails = $this->model->paymentDetails($get_agent, $get_id);
		$this->view->userdata = user::getUserData("agent_id", $get_agent);
		$this->view->accType = user::getAccType($this->user['acc_type']);
		$this->view->to_acc = user::getBanks($this->view->paymentDetails['to_acc'], "fetch");
		$this->view->payment_type = user::getPaymentMethod("itr", "fetch");


		$this->breadcrumb->add("Payment", "management/payment");
		$this->breadcrumb->add("Payment Review", "management/payment_review");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/payment_review.js');
		$this->view->render('management/payment_review', 'backoffice');
	}

	function payment_review_exec() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('id')
				->post('agent_id')
				->post('ads_pin')
				->post('amount')
				->post('status')
				->val('Payment Status', 'minlength')
				->post('remarks');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->payment_review_exec($data);


			$response_array['r'] = $result['r'];
			$response_array['msg'] = $result['msg'];
		} catch (Exception $e) {

			$response_array['r'] = 'false';
			$response_array['msg'] = $e->getMessage();
		}

		echo json_encode($response_array);
	}

	function getWithdrawList() {
		$status = $_GET['status'];
		$p_id = $_GET['p_id'];
		$p = $_GET['p'];
		$s = $_GET['s'];

		$this->model->getWithdrawList($status, $p_id, $p, $s);
	}

	function agentCommission() {

		$agent_id = isset($_REQUEST['agent_id']) ? $_GET['agent_id'] : $this->_userData['agent_id'];

		$userData = user::getUserData("agent_id", $agent_id);
		$this->view->agentData = $userData;

		$this->view->accType = user::getAccType($userData['acc_type']);

		$this->view->commissionType = $this->model->getCommissionType();
		$monthList = $this->model->monthList();
		$this->view->monthList = $monthList;

		$this->view->getTotalCommission = user::getTotalCommission($agent_id, TRUE);
		$this->view->getTotalPayout = user::getTotalPayout($agent_id);
		$this->view->getAvailPayout = user::getAvailableComm($agent_id, TRUE);

		$this->view->pdiList = $this->model->totalCommission($agent_id, "pdi", $monthList);
		$this->view->gdiList = $this->model->totalCommission($agent_id, "gdi", $monthList);
		$this->view->gaiList = $this->model->totalCommission($agent_id, "gai", $monthList);
		$this->view->paiList = $this->model->totalCommission($agent_id, "pai", $monthList);
		$this->view->pbtList = $this->model->totalCommission($agent_id, "pbt", $monthList);
		$this->view->gbtList = $this->model->totalCommission($agent_id, "gbt", $monthList);
		$this->view->aprList = $this->model->totalCommission($agent_id, "apr", $monthList);

		$this->breadcrumb->add("Agent Commission", "management/agentCommission");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/agentCommission.js');
		$this->view->render('management/agentCommission', 'backoffice');
	}

	function commissionList() {
		$type = $_GET['ftype'];
		$month = $_GET['fmonth'];
		$agent_id = $_GET['agent_id'];

		$this->model->commissionList($type, $month, $agent_id);
	}

	function addCommission() {

		$agent_id = isset($_REQUEST['agent_id']) ? $_GET['agent_id'] : $this->_userData['agent_id'];
		$userData = user::getUserData("agent_id", $agent_id);
		$this->view->agentData = $userData;

		$this->view->commType = $this->model->getCommissionType();

		$this->breadcrumb->add("Add Agent Commission", "management/addCommission");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/addCommission.js');
		$this->view->render('management/addCommission', 'backoffice');
	}

	function getSubject() {
		$type = $_POST['type'];

		$result = $this->model->getSubject($type);

		echo json_encode($result);
	}

	public function getAgentId() {
		$agent_id = $_GET['agent_id'];

		$usersData = $this->model->getAgentId($agent_id);

		$countUsers = count($usersData);

		$result = "";

		if ($countUsers > 0) {
			foreach ($usersData as $key => $value) {
				$id = $value['agent_id'];
				$username = $value['username'];
				$acc_type = $value['acc_type'];
				$image = $value['image'];

				$result .= "<a class='agentID col-xs-12' href='$id' username='$username' acc-type='$acc_type'><div class='col-xs-3'><div class='thumbnail'>";
				$result .= "<img class='img-responsive' src='$image' />";
				$result .= "</div></div><div class='col-xs-9'>";
				$result .= "<div>$id</div>";
				$result .= "<div>$username</div>";
				$result .= "</div></a>";
			}
		} else {
			$result .= "<div class='text-center'><div class='alert alert-warning'>No record found.</div></div>";
		}

		echo json_encode($result);
	}

	function agentList() {


		$this->breadcrumb->add("Agent List", "management/agentList");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/agentList.js');
		$this->view->render('management/agentList', 'backoffice');
	}

	function ajaxAgentList() {
		$search = $_GET['s'];
		$page = $_GET['p'];

		$this->model->ajaxAgentList($search, $page);
	}

	function agentUpgrade() {

		$agent_id = ($_REQUEST['agent_id']) ? $_GET['agent_id'] : redirect::to("management/agentList");

		$validateID = user::checkExist("user_accounts", "agent_id = $agent_id");

		if (!$validateID) {
			redirect::to("management/agentList");
		} else {
			$userData = user::getUserData("agent_id", $agent_id);
		}

		$this->view->userdata = $userData;
		$this->view->user_acc_type = user::getAccType($userData['acc_type']);

		$this->view->acc_type_list = user::getAccType();
		$this->view->paymentMethodList = user::getPaymentMethod();
		$this->view->bankList = user::getBanks();

		$this->breadcrumb->add("Agent List", "management/agentList");
		$this->breadcrumb->add("Agent Upgrade - " . $userData['fullname'], "management/agentUpgrade");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/agentUpgrade.js');
		$this->view->render('management/agentUpgrade', 'backoffice');
	}

	function upgradeResult() {
		unset($_GET['url']);

		$data = array();

		foreach ($_GET as $key => $value) {
			$data[$key] = $value;
		}

		$userdata = user::getUserData("agent_id", $data['agent_id']);

		$this->view->userdata = $userdata;
		$this->view->acc_type = user::getAccType($userdata['acc_type']);
		$this->view->result = $data;

		$this->breadcrumb->add("Agent List", "management/agentList");
		$this->breadcrumb->add("Agent Upgrade / Result", "management/upgradeResult");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/upgradeResult.js');
		$this->view->render('management/upgradeResult', 'backoffice');
	}

	function getAccDetails() {
		$code = $_POST['code'];

		$data = user::getAccType($code);

		if ($code == "")
			$data = "";

		echo json_encode($data);
	}

	function agentUpgrade_exec() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('agent_id')
				->post('fullname')
				->post('username')
				->post('curr_acc_type')
				->post('acc_type')
				->val('Upgrade To Account', 'minlength')
				->post('ads_pin_limit')
				->post('payment_price')
				->post('payment_for')
				->post('payment_date')
				->val('Upgrade Date', 'minlength')
				->post('payment_type')
				->val('Payment Type', 'minlength')
				->post('payment_time')
				->post('from_acc')
				->val('Payment Details', 'minlength')
				->post('to_acc')
				->val('Pay To Account', 'minlength')
				->post('ref')
				->post('remarks')
				->post('date_submit');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->agentUpgrade_exec($data);


			$response_array['r'] = $result['r'];
			$response_array['msg'] = $result['msg'];
		} catch (Exception $e) {

			$response_array['r'] = 'false';
			$response_array['msg'] = $e->getMessage();
		}

		echo json_encode($response_array);
	}

	function supplier() {
		$has_alert = (isset($_GET['r'])) ? $_GET['r'] : FALSE;
		$text = FALSE;

		if ($has_alert != FALSE) {
			$type = (isset($_GET['t'])) ? $_GET['t'] : FALSE;
			$arg = (isset($_GET['a'])) ? user::getSupplierData("token", $_GET['a']) : redirect::to("supplier");


			switch ($has_alert) {
				case "success":
					$text = "You have successfully ";
					break;
				case "danger":
					$text = "Sorry, you have failed to ";
					break;
				default:
					redirect::to("supplier");
					break;
			}

			switch ($type) {
				case "addnew":
					$text .= "add new free supplier : <b>" . $arg['comp_name'] . "</b>";
					break;

				default:
					redirect::to("supplier");
					break;
			}
		}
		$this->view->alert = $has_alert;
		$this->view->alert_text = $text;

		$monthList = $this->model->monthList();
		$this->view->monthList = $monthList;

		$this->breadcrumb->add("Supplier List", "management/supplier");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/supplier.js');
		$this->view->render('management/supplier', 'backoffice');
	}

	function addSupplier() {

		$this->view->categoryList = user::getCategory();
		$this->view->countryList = user::getCountry();
		$this->view->statesList = user::getStates("MY");
		$this->view->agentList = user::getAgentList("agent_id != 'NULL' ORDER BY username ASC", "agent_id, available_pin, username");

		$this->breadcrumb->add("Add New Supplier", "supplier/addNew");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/addSupplier.js');
		$this->view->render('management/addSupplier', 'backoffice');
	}

	function addSupplier_exec() {

		$response_array = array();

		try {
			$form = new form();
			$form->post('agent_id')
				->val('Agent', 'minlength')
				->post('comp_name')
				->val('Individual / Company Name', 'minlength')
				->post('comp_reg_no')
				->post('comp_address')
				->val('Address', 'minlength')
				->post('comp_postcode')
				->val('Poscode', 'minlength')
				->post('comp_state')
				->val('State', 'minlength')
				->post('state_other')
				->val('State', 'minlength')
				->post('comp_country')
				->val('Country', 'minlength')
				->post('comp_phone1')
				->val('Phone 1', 'minlength')
				->post('comp_phone2')
				->post('comp_fax')
				->post('website')
				->post('category')
				->val('Category', 'minlength')
				->post('tag')
				->val('Keyword Tag', 'minlength')
				->post('desc')
				->val('Description', 'minlength')
				->post('salutation')
				->val('Salutation', 'minlength')
				->post('p_fullname')
				->val('Fullname', 'minlength')
				->post('p_pos')
				->post('p_phone')
				->post('p_mobile')
				->val('Mobile No.', 'minlength')
				->post('p_gender')
				->val('Gender', 'minlength')
				->post('comp_email')
				->val('Email', 'minlength')
				->post('regdate');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->addSupplier_exec($data);


			$response_array['r'] = $result['r'];
			$response_array['msg'] = $result['msg'];
		} catch (Exception $e) {

			$response_array['r'] = 'false';
			$response_array['msg'] = $e->getMessage();
		}

		echo json_encode($response_array);
	}
	
	function ajaxSupplierList() {

		$result = $this->model->ajaxSupplierList();

		echo json_encode($result);
	}
	
	function advertisement() {
		$data = array();
		$data['list'] = $this->model->advertisementList();

		if (isset($_REQUEST['sid'])) {
			$supplier_id = $_GET['sid'];
			$supplier_data = user::getSupplierData("supplier_id", $supplier_id);
			$data['title'] = $supplier_data['comp_name'];

			$this->breadcrumb->add($supplier_data['comp_name'], "advertisement");
		} else {
			$data['title'] = "All advertisement";
			$supplier_data = FALSE;
		}

		$this->view->data = $data;

		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('management/js/advertisement.js');
		$this->view->render('management/advertisement', 'backoffice');
	}
	
	function ajaxAdsDetails() {
		
		$ads_id = $_POST['ads_id'];

		$result = $this->model->ajaxAdsDetails($ads_id);

		echo json_encode($result);
	}

}
