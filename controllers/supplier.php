<?php

class supplier extends controller {

	function __construct() {
		parent::__construct();
		session::init();
		session::loginAuth("supplier");

		$this->breadcrumb->add("Supplier", "supplier");
	}

	function index() {

		$has_alert = (isset($_GET['r'])) ? $_GET['r'] : FALSE;
		$text = FALSE;

		if ($has_alert != FALSE) {
			$type = (isset($_GET['t'])) ? $_GET['t'] : FALSE;
			$arg = (isset($_GET['a'])) ? $_GET['a'] : redirect::to("supplier");


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
					$text .= "add new free supplier : <b>$arg</b>";
					break;

				default:
					redirect::to("supplier");
					break;
			}
		}
		$this->view->alert = $has_alert;
		$this->view->alert_text = $text;

		$agent_id = $this->_userData['agent_id'];

		$monthList = $this->model->monthList();
		$this->view->monthList = $monthList;

		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('supplier/js/index.js');
		$this->view->render('supplier/index', 'backoffice');
	}

	function addNew() {

		$this->view->categoryList = user::getCategory();
		$this->view->countryList = user::getCountry();
		$this->view->statesList = user::getStates("MY");

		$this->breadcrumb->add("Add New Supplier", "supplier/addNew");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('supplier/js/addNew.js');
		$this->view->render('supplier/addNew', 'backoffice');
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

	function ajaxSupplierDesc() {

		$data['view'] = $_POST['view'];
		$data['supplier_id'] = $_POST['supplier_id'];

		$result = $this->model->ajaxSupplierDesc($data);

		echo json_encode($result);
	}

	function details() {
		$supplier_id = isset($_GET['sid']) ? $_GET['sid'] : header("location: " . BASE_PATH . "supplier");
		$supplier_exist = user::checkExist("user_suppliers", "supplier_id = $supplier_id");

		if ($supplier_exist) {
			$supplier_data = user::getSupplierData("supplier_id", $supplier_id);
		} else {
			header("location: " . BASE_PATH . "supplier");
		}
		
		$this->view->supplier_data = $supplier_data;

		$this->view->breadcrumbs = $this->breadcrumb->add("Details","supplier/details");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('supplier/js/details.js');
		$this->view->render('supplier/details', 'backoffice');
	}

}
