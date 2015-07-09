<?php

class mynetwork extends controller {

	public $_geneologyError = FALSE;
	public $_errorMsg = "<b>Username</b> or <b>Agent ID</b> that you looking for is not your downline or not exist.";

	function __construct() {
		parent::__construct();
		session::init();
		session::loginAuth("mynetwork");

		$this->breadcrumb->add("My Network", "mynetwork");
	}

	function index() {
		$agent_id = $this->_userData['agent_id'];
		$monthList = $this->model->monthList();

		$this->view->downlineListPB = $this->model->countDownline($agent_id, "pb", $monthList);
		$this->view->downlineListAA = $this->model->countDownline($agent_id, "aa", $monthList);
		$this->view->downlineListED = $this->model->countDownline($agent_id, "ed", $monthList);
		$this->view->downlineListEP = $this->model->countDownline($agent_id, "ep", $monthList);

		$this->view->monthList = $monthList;

		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('mynetwork/js/index.js');
		$this->view->render('mynetwork/index', 'backoffice');
	}

	function downlineList() {

		$userdata = $this->_userData;

		$this->model->downlineList($userdata);
	}

	function geneology() {

		$this->breadcrumb->add("Geneology", "mynetwork/geneology");
		$agent_id = $this->_userData['agent_id'];

		$this->view->totalAgentsArr = user::totalAgents($agent_id);

		if (isset($_REQUEST['top'])) {

			$top_id = $_GET['top'];

			$userExist = user::checkExist("user_accounts", "agent_id = '$top_id'");

			if (!$userExist) {
				$agent_id = $this->_userData['agent_id'];
				$this->_geneologyError = TRUE;
			} else {
				$valid_top = user::checkGeneology($top_id);

				if ($valid_top) {
					$agent_id = $top_id;
				} else {
					$agent_id = $this->_userData['agent_id'];
					$this->_geneologyError = TRUE;
				}

				$this->breadcrumb->add("$agent_id", "mynetwork/geneology?top=$agent_id");
			}
		}

		$this->view->_geneologyError = $this->_geneologyError;

		$this->view->topUser = $topUser = $this->model->topUser($agent_id);
		$this->view->midUser = $midUser = $this->model->midUser($topUser['agent_id']);
		$this->view->bottomUser = $bottomUser = $this->model->bottomUser($midUser);
		$this->view->autoPlacement_ID = user::generateUpline($this->_userData['agent_id']);

		$sponsor_id = ($this->_userData['sponsor_id'] != NULL) ? $this->_userData['sponsor_id'] : "nodata";

		$this->view->sponsorData = user::getUserData("agent_id", $sponsor_id);

		$this->view->_geneologyError = $this->_geneologyError;
		$this->view->_errorMsg = $this->_errorMsg;


		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('mynetwork/js/geneology.js');
		$this->view->render('mynetwork/geneology', 'backoffice');
	}

	public function addagent() {
		$lv1Exist = isset($_REQUEST['lv1']) ? TRUE : FALSE;

		if (!$lv1Exist) {
			redirect::to("mynetwork/geneology");
		} else {
			$agent_id = $_GET['lv1'];
			$hasData = user::checkExist("user_accounts", "agent_id = '$agent_id'");

			if (!$hasData) {
				redirect::to("mynetwork/geneology");
			} else {
				$newUplineData = $this->model->newUplineData($agent_id);
			}
		}

		$this->view->accTypeList = user::getAccType();
		$this->view->newUplineData = $newUplineData;
		$this->view->countryList = user::getCountry();
		$this->view->statesList = user::getStates("MY");

		$this->breadcrumb->add("Geneology", "mynetwork/geneology");
		$this->breadcrumb->add("Add Agent", "mynetwork/addagent");
		$this->view->breadcrumbs = $this->breadcrumb->get();
		$this->view->js = array('mynetwork/js/addagent.js');
		$this->view->render('mynetwork/addagent', 'backoffice');
	}

	public function addagent_exec() {
		$response_array = array();

		try {
			$form = new form();
			$form->post('acc_type')
				->val('Account Type', 'minlength')
				->post('sponsor_id')
				->val('Sponsor ID', 'minlength')
				->post('lv1')
				->val('Upline ID', 'minlength')
				->post('salutation')
				->val('Salutation', 'minlength')
				->post('fullname')
				->val('Fullname', 'minlength')
				->post('ic_no')
				->val('IC Number', 'digit')
				->post('dob')
				->val('Date Of Birth', 'minlength')
				->post('address')
				->val('Mailing Address', 'minlength')
				->post('country')
				->val('Country', 'minlength')
				->post('states')
				->post('gender')
				->val('Gender', 'minlength')
				->post('phone')
				->post('mobile')
				->val('Mobile', 'minlength')
				->post('username')
				->val('Username', 'minlength')
				->post('chkusername')
				->post('email')
				->val('Email', 'minlength')
				->post('cemail')
				->val('Confirm Email', 'minlength')
				->post('lv2')
				->post('lv3')
				->post('lv4')
				->post('lv5')
				->post('lv6')
				->post('lv7')
				->post('lv8')
				->post('lv9')
				->post('lv10')
				->post('dt_join')
				->post('subscribe');

			$form->submit();

			$data = $form->fetch();

			$result = $this->model->addagent_exec($data);

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

	public function addagent_success($agent_id) {
		$this->breadcrumb->add("Geneology", "mynetwork/geneology");
		$this->breadcrumb->add("Add Agent", "mynetwork/addagent");
		$this->breadcrumb->add("Successful", "mynetwork/addagent_success");
		$this->view->breadcrumbs = $this->breadcrumb->get();

		if (isset($agent_id)) {
			$verify = user::checkExist("user_accounts", "agent_id = '$agent_id'");

			if (!$verify) {
				redirect::to("mynetwork/geneology");
				exit();
			} else {

				$data = user::getUserData("agent_id", $agent_id);
				$this->view->userdata = $data;

				$this->view->js = array('mynetwork/js/addagent_success.js');
				$this->view->render('mynetwork/addagent_success', "backoffice");
			}
		} else {
			redirect::to();
			exit();
		}
	}

	public function getSponsorId() {
		$agent_id = $_GET['agent_id'];

		$usersData = $this->model->getSponsorId($agent_id);

		$countUsers = count($usersData);

		$result = "";

		if ($countUsers > 0) {
			foreach ($usersData as $key => $value) {
				$id = $value['agent_id'];
				$username = $value['username'];
				$image = $value['image'];

				$result .= "<a class='agentID col-xs-12' href='$id'><div class='col-xs-3'><div class='thumbnail'>";
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

}
