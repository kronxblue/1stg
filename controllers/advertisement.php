<?php

class advertisement extends controller {

	function __construct() {
		parent::__construct();
		session::init();
		session::loginAuth("advertisement");

		$this->breadcrumb->add("Advertisement", "advertisement");
	}

	function index() {

		$data = array();
		$data['list'] = $this->model->advertisementList();

		if (isset($_REQUEST['sid'])) {
			$supplier_id = $_GET['sid'];
			$supplier_data = user::getSupplierData("supplier_id", $supplier_id);

			$this->breadcrumb->add($supplier_data['comp_name'], "advertisement");
		} else {
			$data['title'] = "Summary";
			$supplier_data = FALSE;
		}

		$this->view->supplier_data = $supplier_data;

		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('advertisement/js/index.js');
		$this->view->render('advertisement/index', 'backoffice');
	}

	function addNew() {

		$agent_id = session::get(AGENT_SESSION_NAME);

		if (isset($_REQUEST['sid'])) {
			$supplier_id = $_GET['sid'];
			$supplier_data = user::getSupplierData("supplier_id", $supplier_id);
		} else {
			$supplier_data = FALSE;
		}

		$this->view->supplier_data = $supplier_data;
		$this->view->supplier_list = user::getSupplierList("agent_id = '$agent_id'", "comp_name, supplier_id");

		$this->view->categoryList = user::getCategory();
		$this->view->countryList = user::getCountry();
		$this->view->statesList = user::getStates("MY");

		$this->breadcrumb->add("Add New Advertisement", "advertisement/addNew");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('advertisement/js/addNew.js');
		$this->view->render('advertisement/addNew', 'backoffice');
	}

	function addNew_exec() {

		$response_array = array();

		try {
			$form = new form();
			$form->post('comp_name')
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

			$result = $this->model->addNew_exec($data);

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

	function ajaxAdsList() {

		$result = $this->model->ajaxAdsList();

		echo json_encode($result);
	}

}
