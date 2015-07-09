<?php

class setup_model extends model {

	function __construct() {
		parent::__construct();
		session::init();
	}

	public function savePassword($data) {

		$response_array = array();

		$agent_id = $data['agent_id'];
		$password = $data['password'];
		$cpassword = $data['cpassword'];

		$checkCPassword = user::checkCdata($password, $cpassword);

		if (!$checkCPassword) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Confirm Password</b> not match!</div>";
		} else {

			$data['tmp_password'] = NULL;
			$data['password'] = hash::create("sha256", $password, HASH_PASSWORD_KEY);

//            Insert into Database
			$this->db->update("user_accounts", $data, "agent_id = '$agent_id'");

//            Response
			$response_array['r'] = "true";
			$response_array['msg'] = BASE_PATH . "setup/details";
		}

		return $response_array;
	}

	public function saveDetails($data) {

		$response_array = array();

		$agent_id = $data['agent_id'];

		foreach ($data as $key => $value) {
			if ($value == "") {
				$data[$key] = NULL;
			}
		}

		$data['address'] = ucwords($data['address']);

		$data['mobile'] = str_replace("-", "", $data['mobile']);
		$data['mobile'] = str_replace(" ", "", $data['mobile']);
		$data['mobile'] = str_replace("+6", "", $data['mobile']);
		$data['mobile'] = "+6" . $data['mobile'];

		if (!empty($data['phone'])) {
			$data['phone'] = str_replace("-", "", $data['phone']);
			$data['phone'] = str_replace(" ", "", $data['phone']);
			$data['phone'] = str_replace("+6", "", $data['phone']);
			$data['phone'] = "+6" . $data['phone'];
		}

//        Insert into Database
		$this->db->update("user_accounts", $data, "agent_id = '$agent_id'");

//        Response
		$response_array['r'] = "true";
		$response_array['msg'] = BASE_PATH . "setup/bank";

		return $response_array;
	}

	public function skipBank($data) {

		$response_array = array();

		$agent_id = $data['agent_id'];

		foreach ($data as $key => $value) {
			if ($value == "") {
				$data[$key] = NULL;
			}
		}

		$updateData = array();
		$updateData['bank_chk'] = 1;

		$this->db->update("user_accounts", $updateData, "agent_id = $agent_id");

//        Response
		$response_array['r'] = "true";
		$response_array['msg'] = BASE_PATH . "setup/beneficiary";

		return $response_array;
	}

	public function saveBank($data) {

		$response_array = array();

		$agent_id = $data['agent_id'];
		$data['holder_name'] = ucwords($data['holder_name']);

		$bankExist = user::checkExist("user_banks", "agent_id = '$agent_id'");

//        Insert into Database
		if (!$bankExist) {
			$this->db->insert("user_banks", $data, "agent_id = '$agent_id'");
		} else {
			$this->db->update("user_banks", $data, "agent_id = '$agent_id'");
		}
		
		$u = array();
		$u['bank_chk'] = 2;
		
		$this->db->update("user_accounts", $u, "agent_id = '$agent_id'");
		
		
//        Response
		$response_array['r'] = "true";
		$response_array['msg'] = BASE_PATH . "setup/beneficiary";

		return $response_array;
	}

	public function skipBeneficiary($data) {

		$response_array = array();

		$agent_id = $data['agent_id'];

		foreach ($data as $key => $value) {
			if ($value == "") {
				$data[$key] = NULL;
			}
		}

		$updateData = array();
		$updateData['beneficiary_chk'] = 1;

		$this->db->update("user_accounts", $updateData, "agent_id = $agent_id");

//        Response
		$response_array['r'] = "true";
		$response_array['msg'] = BASE_PATH . "setup/payment";

		return $response_array;
	}

	public function saveBeneficiary($data) {

		$response_array = array();

		$agent_id = $data['agent_id'];
		$data['name'] = ucwords($data['name']);
		$data['contact'] = str_replace("-", "", $data['contact']);
		$data['contact'] = str_replace(" ", "", $data['contact']);
		$data['contact'] = str_replace("+6", "", $data['contact']);
		$data['contact'] = "+6" . $data['contact'];

		$beneficiaryExist = user::checkExist("user_beneficiary", "agent_id = $agent_id");

//        Insert into Database
		if (!$beneficiaryExist) {
			$this->db->insert("user_beneficiary", $data, "agent_id = '$agent_id'");
		} else {
			$this->db->update("user_beneficiary", $data, "agent_id = '$agent_id'");
		}
		
		$u = array();
		$u['beneficiary_chk'] = 2;
		
		$this->db->update("user_accounts", $u, "agent_id = '$agent_id'");

//        Response
		$response_array['r'] = "true";
		$response_array['msg'] = BASE_PATH . "setup/payment";

		return $response_array;
	}

	public function savePayment($data) {

		$response_array = array();

		foreach ($data as $key => $value) {
			if ($value == "") {
				$data[$key] = NULL;
			}
		}

		$agent_id = $data['agent_id'];
		$data['from_acc'] = ucwords($data['from_acc']);
		$data['ref'] = ucwords($data['ref']);

		$dateTime = $data['payment_date'] . " " . $data['payment_time'];
		$dateNow = $data['date_submit'];

		$acc_type = $this->db->select("user_accounts", "acc_type", "agent_id = '$agent_id'", "fetch");
		$acc_type = $acc_type['acc_type'];
		$ads_pin = $data['ads_pin'];



		if ($acc_type != "pb") {
			$pin_data = $this->db->select("user_accounts", "*", "agent_id = '$ads_pin'", "fetch");
			$pin_acc_type = $pin_data['acc_type'];

			switch ($acc_type) {
				case "ep":
					$pinValid = ($pin_acc_type == "admin") ? TRUE : FALSE;
					break;
				default:
					$hasReseller = $this->db->count("user_accounts", "payment = '2' AND (acc_type = 'ep' OR acc_type = 'ed') AND available_pin > '0'");

					if ($hasReseller > 0) {
						$pinValid = ($pin_acc_type == "admin") ? FALSE : TRUE;
					} else {
						$pinValid = ($pin_acc_type == "admin") ? TRUE : FALSE;
					}
					break;
			}
		} else {
			$pinValid = TRUE;
		}



		if (($acc_type != "pb") and ( $ads_pin == NULL)) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Advertisement Pin</b> cannot be empty.</div>";
		} elseif (!$pinValid) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Advertisement Pin</b> not valid. Executive partner should use Administrator Pin.</div>";
		} elseif ($data['payment_price'] > $data['amount']) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Amount</b> not enough.</div>";
		} elseif ($dateTime > $dateNow) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Payment Date</b> not valid.</div>";
		} else {

			$data['payment_bal'] = $data['payment_price'] - $data['amount'];
			$paymentExist = user::checkExist("user_payment", "agent_id = '$agent_id' AND status = '0'");

			if ($acc_type != "pb") {

//        Deduct Advertisement Pin from reseller
				$pin_owner = $this->db->select("user_accounts", "acc_type,available_pin", "agent_id = '$ads_pin'", "fetch");

				if ($pin_owner['acc_type'] != 'admin' and $pin_owner['acc_type'] != 'md') {
					$pin_balance = $pin_owner['available_pin'] - 1;
					$data3['available_pin'] = $pin_balance;

					$this->db->update("user_accounts", $data3, "agent_id = '$ads_pin'");
				}

				$data2['ads_pin'] = $data['ads_pin'];
			}

			$data2['payment'] = 1;

//        Update Advertisement Pin in user account
			$this->db->update("user_accounts", $data2, "agent_id = '$agent_id'");

			unset($data['ads_pin']);

//        Insert into Database
			if (!$paymentExist) {
				$this->db->insert("user_payment", $data, "agent_id = '$agent_id'");
			} else {
				$this->db->update("user_payment", $data, "agent_id = '$agent_id' AND status = '0'");
			}

//        GENERATE EMAIL TO ADMIN

			$userdata = $this->db->select("user_accounts", "*", "agent_id = '$agent_id'", "fetch");
			$site_setting = $this->db->select("site_settings", "*", "name = 'company_name'", "fetch");

			$fullname = ucwords(strtolower($userdata['fullname']));
			$agent_id = $data['agent_id'];
			$payment_for = $data['payment_for'];
			$date_time = $data['payment_date'] . " " . $data['payment_time'];
			$date_time = date("d M Y / H:i:s", strtotime($date_time));
			$from_acc = strtoupper($data['from_acc']);
			$to_acc = user::getBanks($data['to_acc'], "fetch");
			$to_acc = strtoupper($to_acc['code']) . " [" . $site_setting['param'] . "] - " . $to_acc['acc_no'];
			$pay_method = user::getPaymentMethod($data['payment_type'], "fetch");
			$pay_method = $pay_method['pay_method'];
			$ref = ($data['ref'] != NULL) ? $data['ref'] : "-";
			$amount = "RM" . number_format($data['amount']);


//        Generate Email BODY

			$html = file_get_contents(BASE_PATH . 'email_template/payment_received');
			$html = htmlspecialchars($html);

			$html = str_replace('[FULLNAME]', $fullname, $html);
			$html = str_replace('[AGENT_ID]', $agent_id, $html);
			$html = str_replace('[PAYMENT_FOR]', $payment_for, $html);
			$html = str_replace('[DATE_TIME]', $date_time, $html);
			$html = str_replace('[FROM_ACC]', $from_acc, $html);
			$html = str_replace('[TO_ACC]', $to_acc, $html);
			$html = str_replace('[PAYMENT_TYPE]', $pay_method, $html);
			$html = str_replace('[REF]', $ref, $html);
			$html = str_replace('[AMOUNT]', $amount, $html);

			$html = html_entity_decode($html);

			$body = $html;


//            Send Email
			$mailer = new mailer();

			$mailer->IsSMTP(); // set mailer to use SMTP
			$mailer->Port = EMAIL_PORT;
			$mailer->Host = EMAIL_HOST;  // specify main and backup server
			$mailer->SMTPAuth = true; // turn on SMTP authentication
			$mailer->Username = NOREPLY_EMAIL;     // SMTP username
			$mailer->Password = NOREPLY_PASS;    // SMTP password
			$mailer->From = NOREPLY_EMAIL;
			$mailer->FromName = SUPPORT_NAME;
			$mailer->AddAddress(FINANCE_EMAIL);
			$mailer->IsHTML(true);

			$mailer->Subject = "NEW Payment Received [" . $fullname . "]";
			$mailer->Body = $body;
			$mailer->Send();

//        Response
			$response_array['r'] = "true";
			$response_array['msg'] = BASE_PATH . "setup/complete";
		}




		return $response_array;
	}

	public function getListPin() {

		$self_address = BASE_PATH . "setup/listPin";

		$page = isset($_REQUEST['page']) ? $_GET['page'] : "1";
		$filter = "acc_type = 'ep'";
		$sort = isset($_REQUEST['sort']) ? $_GET['sort'] : "ORDER BY available_pin DESC";
		$acc_type = isset($_REQUEST['acc_type']) ? $_GET['acc_type'] : "ad";

		$header = "<table class='table table-bordered table-condensed'><thead><tr class='active'><th class='text-center' width='50'>#</th><th class='text-center' width='150'>Available Pin</th><th class='text-center'  width='200'>Pin Code</th><th class='text-center'>Acc. Type</th><th class='text-center' width='150'>Action</th></tr></thead><tbody>";
		$content = "";
		$footer = "</tbody></table>";
		$pagination = "";


		$resellerExist = user::checkExist("user_accounts", "(acc_type = 'ep') AND (activate = '1') AND (payment = '2')");

		switch ($acc_type) {
			case "ed":
				$resellerExist = user::checkExist("user_accounts", "activate = '1' AND payment = '2' AND available_pin > 0 AND ($filter) $sort");
				break;
			case "ep":
				$resellerExist = FALSE;
				break;

			default:
				break;
		}

		if (!$resellerExist) {

			$adminDetails = $this->db->select("user_accounts", "agent_id,available_pin,acc_type", "acc_type = 'admin'", "fetch");

			$available_pin = $adminDetails['available_pin'];
			$pin_code = $adminDetails['agent_id'];
			$getAccType = user::getAccType($adminDetails['acc_type']);
			$acc_type = $getAccType['label'];

			$content .= "<tr class='text-center'>";

			$content .= "<td>1</td>";
			$content .= "<td>$available_pin</td>";
			$content .= "<td>$pin_code</td>";
			$content .= "<td>$acc_type</td>";
			$content .= "<td><button class='btnSelect btn btn-primary btn-xs' type='button' data-pin='$pin_code'>Select</button></td>";

			$content .= "</tr>";
		} else {

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 15;

			$from = (($current_page * $max_result) - $max_result);


			$resellerList_full = $this->db->select("user_accounts", "*", "activate = '1' AND payment = '2' AND available_pin > 0 AND ($filter) $sort");

			$total_row = count($resellerList_full);

			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			if ($current_page > 1) {
				$pagination .= "<li><a class='rfalse pagination-link' href='$self_address#$prev_page' data-page='$prev_page'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			} else {
				$pagination .= "<li class='disabled'><a class='rfalse' href='#'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			}

			if ($current_page >= 7) {
				$pagination .= "<li><a class='rfalse pagination-link' href='$self_address#1' data-page='1'>1</a></li>";
				$pagination .= "<li class='disabled'><a class='rfalse' href='#'>..</a></li>";
			}

			for ($i = max(1, $current_page - 5); $i <= min($current_page + 5, $total_pages); $i++) {
				if (($current_page) == $i) {
					$pagination .= "<li class='active'><a class='rfalse' href='#'>$i</a></li>";
				} else {
					$pagination .= "<li><a class='rfalse pagination-link' href='$self_address#$i' data-page='$i'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a class='rfalse' href='#'>..</a></li>";
				$pagination .= "<li><a class='rfalse pagination-link' href='$self_address#$total_pages' data-page='$total_pages'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a class='rfalse pagination-link' href='$self_address#$next_page' data-page='$next_page'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a class='rfalse' href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";

			$resellerList_limit = $this->db->select("user_accounts", "*", "activate = '1' AND payment = '2' AND available_pin > 0 AND ($filter) $sort LIMIT $from,$max_result");

			if ($total_row == 0) {
//                $content .= "<tr><td class ='text-center' colspan='8'>No downline record.</td></tr>";
//                $pagination = NULL;
			} else {
				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($resellerList_limit as $value) {

					$highlight = ($value['acc_type'] == "ep") ? "warning" : NULL;

					$acc_type = user::getAccType($value['acc_type']);

//                CONSTRUCT CONTENT
					$available_pin = $value['available_pin'];
					$pin_code = $value['agent_id'];
					$acc_type = $acc_type['label'];

					$content .= "<tr class='text-center $highlight'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$available_pin</td>";
					$content .= "<td>$pin_code</td>";
					$content .= "<td>$acc_type</td>";
					$content .= "<td><button class='btnSelect btn btn-primary btn-xs' type='button' data-pin='$pin_code'>Select</button></td>";

					$content .= "</tr>";
					$x++;
				}
			}
		}


		$result = $header . $content . $footer . $pagination;

		echo json_encode($result);
	}

	public function checkPin($data) {

		$response_array = array();

		$agent_id = $data['pin'];
		$userExist = user::checkExist("user_accounts", "agent_id = '$agent_id'");

		if (!$userExist) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Advertisement Pin</b> not valid!</div>";
		} else {

			$userdata = $this->db->select("user_accounts", "*", "agent_id = '$agent_id'", "fetch");

			$header = "<table class='table table-bordered table-condensed'><thead><tr class='active'><th class='text-center' width='50'>#</th><th class='text-center' width='150'>Available Pin</th><th class='text-center'  width='200'>Pin Code</th><th class='text-center'>Acc. Type</th><th class='text-center' width='150'>Action</th></tr></thead><tbody>";
			$content = "";
			$footer = "</tbody></table>";

			$acc_type = $userdata['acc_type'];
			$activate = $userdata['activate'];
			$payment = $userdata['payment'];
			$available_pin = $userdata['available_pin'];

			if (($acc_type == "pb") or ( $acc_type == "aa") or ( $activate == 0) or ( $payment != 2)) {
				$response_array['r'] = "false";
				$response_array['msg'] = "<div><b>Advertisement Pin</b> not valid!</div>";
			} elseif ($available_pin == 0) {
				$response_array['r'] = "false";
				$response_array['msg'] = "<div>Insufficient <b>Advertisement Pin</b> balance!</div>";
			} else {

//                CONSTRUCT CONTENT
				$highlight = ($userdata['acc_type'] == "ep") ? "warning" : NULL;

				$pin_code = $userdata['agent_id'];
				$accType = user::getAccType($acc_type);
				$accType = $accType['label'];

				$content .= "<tr class='text-center $highlight'>";

				$content .= "<td>1</td>";
				$content .= "<td>$available_pin</td>";
				$content .= "<td>$pin_code</td>";
				$content .= "<td>$accType</td>";
				$content .= "<td><button class='btnSelect btn btn-primary btn-xs' type='button' data-pin='$pin_code'>Select</button></td>";

				$content .= "</tr>";

				$result = $header . $content . $footer;
				$response_array['r'] = "true";
				$response_array['msg'] = $result;
			}
		}

		return $response_array;
	}

}
