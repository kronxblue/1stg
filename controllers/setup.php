<?php

class setup extends controller {

	private $user;

	function __construct() {
		parent::__construct();
		session::init();
		session::loginAuth("setup");
		$this->breadcrumb->add("Account Setup", "setup");

		$this->user = user::getUserData('agent_id', session::get(AGENT_SESSION_NAME));
	}

	function index() {

		$accountCheck = session::accountCheck($this->user);

		if (!$accountCheck) {
			redirect::to('dashboard');
		} else {
			redirect::to($accountCheck);
		}
	}

	function password() {

		$userdata = $this->user;

		if ($userdata['tmp_password'] == NULL) {
			redirect::to("setup/details");
		}

		$this->breadcrumb->add("Setup New Password", "setup/password");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('setup/js/setup.js');
		$this->view->render('setup/password', 'backoffice');
	}

	function details() {
		$userdata = $this->user;
		$detailsComplete = TRUE;

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$agent_id = $userdata['agent_id'];
		$details = $db->select("user_accounts", "address,country,states,gender,ic_no,mobile", "agent_id = '$agent_id'", "fetch");

		if ($userdata['acc_type'] != 'admin' and $userdata['acc_type'] != 'md') {
			foreach ($details as $key => $value) {
				if (empty($value)) {
					$detailsComplete = FALSE;
				}
			}

			if ($detailsComplete) {
				redirect::to("setup/bank");
			}
		} else {
			redirect::to("dashboard");
		}

		$this->view->countryList = user::getCountry();
		$this->view->statesList = user::getStates("MY");

		$this->breadcrumb->add("Personal Details", "setup/details");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('setup/js/setup.js');
		$this->view->render('setup/details', 'backoffice');
	}

	function bank() {
		$userdata = $this->user;
		$agent_id = $userdata['agent_id'];

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$bank_chk = $userdata['bank_chk'];

		if ($bank_chk == 2) {
			redirect::to("setup/beneficiary");
		}

		$this->view->bankData = $db->select("user_banks", "*", "agent_id = $agent_id", "fetch");

		$this->view->bankList = user::getBanks();

		$this->breadcrumb->add("Bank Account Details", "setup/bank");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('setup/js/setup.js');
		$this->view->render('setup/bank', 'backoffice');
	}

	function beneficiary() {
		$userdata = $this->user;
		$agent_id = $userdata['agent_id'];

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$beneficiary_chk = $userdata['beneficiary_chk'];

		if ($beneficiary_chk == 2) {
			redirect::to("setup/payment");
		}

		$this->view->beneficiaryData = $db->select("user_beneficiary", "*", "agent_id = $agent_id", "fetch");

		$this->view->bankList = user::getBanks();

		$this->breadcrumb->add("Beneficiary Details", "setup/beneficiary");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('setup/js/setup.js');
		$this->view->render('setup/beneficiary', 'backoffice');
	}

	function payment() {
		$userdata = $this->user;
		$agent_id = $userdata['agent_id'];
		$paymentComplete = TRUE;

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		
		$payment_chk = $userdata['payment'];

		if (($payment_chk == 2) or ($payment_chk == 1)) {
			redirect::to("dashboard");
		}


		$this->view->bankList = user::getBanks();
		$this->view->paymentMethodList = user::getPaymentMethod();
		$this->view->accType = user::getAccType($this->user['acc_type']);

		$this->breadcrumb->add("Payment Details", "setup/payment");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('setup/js/setup.js');
		$this->view->render('setup/payment', 'backoffice');
	}

	public function listPin() {
		$this->view->js = array('setup/js/pinList.js');
		$this->view->render('setup/listPin', 'blank');
	}

	public function getListPin() {
		$this->model->getListPin();
	}

	public function checkPin() {

		$response_array = array();

		try {
			$form = new form();
			$form->post('pin')
				->val('Pin', 'minlength');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->checkPin($data);


			$response_array['r'] = $result['r'];
			$response_array['msg'] = $result['msg'];
		} catch (Exception $e) {

			$response_array['r'] = 'false';
			$response_array['msg'] = $e->getMessage();
		}

		echo json_encode($response_array);
	}

	function complete() {
		$userdata = $this->user;
		$agent_id = $userdata['agent_id'];
		$paymentComplete = TRUE;

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$hasPayment = user::checkExist("user_payment", "agent_id = '$agent_id'");
		$paymentDetails = $db->select("user_payment", "payment_date, payment_time, from_acc, to_acc, payment_type", "agent_id = '$agent_id'", "fetch");

		if ($paymentDetails != FALSE) {
			foreach ($paymentDetails as $key => $value) {
				if (empty($value)) {
					$paymentComplete = FALSE;
				}
			}
		} else {
			$paymentComplete = FALSE;
		}

		if (!$hasPayment or ! $paymentComplete) {
			redirect::to("setup/payment");
		}

		$this->breadcrumb->add("Complete", "setup/complete");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('setup/js/setup.js');
		$this->view->render('setup/complete', 'backoffice');
	}

	function savePassword() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('agent_id')
				->post('password')
				->val('Password', 'minlength', 6)
				->post('cpassword')
				->val('Confirm Password', 'minlength');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->savePassword($data);

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

	function saveDetails() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('agent_id')
				->post('ic_no')
				->val('IC Number', 'maxlength', 12)
				->val('IC Number', 'digit')
				->post('gender')
				->val('Gender', 'minlength')
				->post('address')
				->val('Mailing Address', 'minlength')
				->post('mobile')
				->val('Mobile Number', 'minlength', 10)
				->post('phone')
				->post('country')
				->val('Nationality', 'minlength')
				->post('states');

			$form->submit();

			if ($_POST['country'] == 'MY') {
				$form->post('states')
					->val('States', 'minlength');

				$form->submit();
			}

			$data = $form->fetch();

			$result = $this->model->saveDetails($data);

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

	function skipBank() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('agent_id')
				->post('bank_name')
				->post('acc_no')
				->post('holder_name');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->skipBank($data);

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

	function saveBank() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('agent_id')
				->post('bank_name')
				->val('Bank Name', 'minlength')
				->post('holder_name')
				->val('Acount Holder Name', 'minlength')
				->post('acc_no')
				->val('Account Number', 'minlength')
				->val('Account Number', 'digit');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->saveBank($data);

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

	function skipBeneficiary() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('agent_id')
				->post('name')
				->post('ic_no')
				->post('contact')
				->post('bank_name')
				->post('bank_acc_no');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->skipBeneficiary($data);

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

	function saveBeneficiary() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('agent_id')
				->post('name')
				->val('Beneficiary Name', 'minlength')
				->post('ic_no')
				->val('Beneficiary IC No.', 'minlength')
				->val('Beneficiary IC No.', 'maxlength', 12)
				->val('Beneficiary IC No.', 'digit')
				->post('contact')
				->val('Beneficiary Contact No.', 'minlength')
				->post('bank_name')
				->val('Bank Name', 'minlength')
				->post('bank_acc_no')
				->val('Bank Account No.', 'minlength');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->saveBeneficiary($data);

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

	

	function savePayment() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('agent_id')
				->post('payment_for')
				->post('ads_pin')
				->post('payment_date')
				->val('Payment Date', 'minlength')
				->post('payment_time')
				->val('Payment Time', 'minlength')
				->post('from_acc')
				->val('From Account', 'minlength')
				->post('to_acc')
				->val('To Account', 'minlength')
				->post('payment_type')
				->val('Payment Type', 'minlength')
				->post('ref')
				->post('amount')
				->val('Amount', 'minlength')
				->val('Amount', 'digit')
				->post('payment_price')
				->post('date_submit');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->savePayment($data);

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
