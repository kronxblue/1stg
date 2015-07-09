<?php

class supp extends controller {

	function __construct() {
		parent::__construct();
		$this->breadcrumb->add("Supplier", "supp");
	}

	function index() {
		$this->view->js = array('supp/js/index.js');
		$this->view->render('supp/index');
	}

	function register() {

		$this->view->referral = $this->model->getReferral();

		$this->view->categoryList = user::getCategory();
		$this->view->countryList = user::getCountry();
		$this->view->statesList = user::getStates("MY");

		$this->view->js = array('supp/js/register.js');
		$this->view->render('supp/register');
	}

	function register_exec() {

		$response_array = array();

		try {
			$form = new form();
			$form->post('comp_name')
				->val('Individual / Company Name', 'minlength')
				->post('comp_reg_no')
				->post('comp_address')
				->val('Address', 'minlength')
				->post('comp_postcode')
				->val('Postcode', 'digit')
				->post('comp_state')
				->val('State', 'minlength')
				->post('state_other')
				->val('State', 'minlength')
				->post('comp_country')
				->val('Country', 'minlength')
				->post('comp_phone1')
				->val('Phone 1', 'digit')
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
				->val('Email', 'email')
				->post('username')
				->val('Username', 'minlength')
				->post('pass')
				->val('Password', 'minlength', 6)
				->post('confpass')
				->val('Confirm Password', 'minlength')
				->post('agent_id')
				->post('regdate');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->register_exec($data);

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

	function success($supplier_username = NULL) {
		$this->breadcrumb->add("Registration", "supp/register");
		$this->breadcrumb->add("Successful", "supp/success");
		$this->view->breadcrumbs = $this->breadcrumb->get();

		if (isset($supplier_username)) {
			$verify = user::checkExist("supplier", "username = '$supplier_username'");

			if (!$verify) {
				redirect::to();
				exit();
			} else {

				$data = user::getSupplierData("username", $supplier_username);
				$this->view->userdata = $data;

				$this->view->js = array('supp/js/success.js');
				$this->view->render('supp/success');
			}
		} else {
			redirect::to();
			exit();
		}
	}

	function resend_activation() {

		$email = $_POST['email'];

		$data = user::getSupplierData('comp_email', $email);
		if ($data != FALSE) {
			$result = $this->model->resend_activation($data);
		} else {
			$result = FALSE;
		}


		echo json_encode($result);
	}

	function verify() {
		$activation_code = isset($_REQUEST['a']) ? $_GET['a'] : FALSE;
		$salt = isset($_REQUEST['s']) ? $_GET['s'] : FALSE;

		$verify = $this->model->verify($activation_code, $salt);


		$this->view->js = array('supp/js/register.js');

		if ($verify) {
			$this->model->sendWelcomeEmail($salt);

			$this->breadcrumb->add("Activation Success", "supp/verifySuccess");
			$this->view->breadcrumbs = $this->breadcrumb->get();
			$this->view->render('supp/verifySuccess');
		} else {
			
			$this->breadcrumb->add("Activation Failed", "supp/verifyFailed");
			$this->view->breadcrumbs = $this->breadcrumb->get();
			$this->view->render('supp/verifyFailed');
		}
		
		
	}

}
