<?php

class tools extends controller {

	function __construct() {
		parent::__construct();
		session::init();
		session::loginAuth("supplier");

		$this->breadcrumb->add("Tools", "supplier");
	}

	function index() {

		$this->view->tools = $this->model->tools();

		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('tools/js/index.js');
		$this->view->render('tools/index', 'backoffice');
	}

	function download() {

		$id = $_POST['id'];

		$result = $this->model->download($id);

		echo json_encode($result);
	}

}
