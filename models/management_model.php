<?php

class management_model extends model {

	function __construct() {
		parent::__construct();
		session::init();
	}

	public function userlists() {
		$data = $this->db->select("user_accounts", "agent_id");

		return $data;
	}

	public function paymentlists() {
		$data = $this->db->select("user_banks", "agent_id");

		return $data;
	}

	public function monthList($sort = NULL) {
		$monthList = array();
		$date = date("M Y");
		for ($i = 0; $i < 12; $i++) {
			if ($sort != NULL) {
				$monthList[$i] = date("M Y", strtotime("15 $date -$i months"));
				ksort($monthList);
			} else {
				if ($i <= 6) {
					$k = 6 - $i;
					$monthList[$i] = date("M Y", strtotime("15 $date -$k months"));
				} else {
					$k = $i - 6;
					$monthList[$i] = date("M Y", strtotime("15 $date +$k months"));
				}
			}
		}

		return $monthList;
	}

	public function totalCommission($agent_id, $commType, $monthList) {
		$commListArr = array();
		$totalMonthlyComm = 0;

		$i = 0;
		foreach ($monthList as $value) {
			$start_date = date("Y-m-d H:i:s", strtotime($value . "-1"));
			$end_date = date("Y-m-t H:i:s", strtotime($value));

			$commListArr[$i] = $this->db->select("user_commissions", "amount", "agent_id = '$agent_id' AND type = '$commType' AND (date_release >= '$start_date' AND date_release <= '$end_date') AND f = 0");

			$countCommList = count($commListArr[$i]);
			if ($countCommList != 0) {
				foreach ($commListArr[$i] as $value) {
					$totalMonthlyComm = $totalMonthlyComm + $value['amount'];
				}
			} else {
				$totalMonthlyComm = 0;
			}

			$data[] = $totalMonthlyComm;

			$totalMonthlyComm = 0;
			$i++;
		}

		return $data;
	}

	public function getCommissionType() {
		$data = $this->db->select("commissions_type", "*");

		return $data;
	}

	public function getSubject($type) {

		$data = $this->db->select("commissions_type", "*", "code = '$type'", "fetch");

		if ($data == FALSE) {
			$result = FALSE;
		} else {
			$result = array();

			if ($type == "pai" OR $type == "pbt") {
				$dataType = 0;
			} else {
				$dataType = 1;
			}

			$result['dataType'] = $dataType;
			$result['subject'] = $data['subject'];
			$result['placeholder'] = "Enter " . $data['from'] . ".";
		}




		return $result;
	}

	public function getAgentId($agent_id) {

		$owner_ID = session::get(AGENT_SESSION_NAME);
		$mydata = $this->db->select("user_accounts", "agent_id,username", "agent_id = '$owner_ID'", "fetch");


		$cond = "(agent_id LIKE '%$agent_id%' OR username LIKE '%$agent_id%') AND (lv1 = '$owner_ID' OR lv2 = '$owner_ID' OR lv3 = '$owner_ID' OR lv4 = '$owner_ID' OR lv5 = '$owner_ID' OR lv6 = '$owner_ID' OR lv7 = '$owner_ID' OR lv8 = '$owner_ID' OR lv9 = '$owner_ID' OR lv10 = '$owner_ID') LIMIT 0,10";
		$usersData = $this->db->select("user_accounts", "agent_id, username, acc_type", $cond);

		if ((strpos($mydata['agent_id'], $agent_id) !== FALSE) or ( strpos($mydata['username'], $agent_id) !== FALSE)) {
			$usersData[] = $mydata;
		}

		foreach ($usersData as $key => $value) {
			$userID = $value['agent_id'];
			$acc_type = $value['acc_type'];
			$imageExist = user::checkExist("user_images", "agent_id = '$userID' and profile = '1'");
			if ($imageExist) {
				$image = user::getUserImages($userID, TRUE);
				$imagePath = IMAGES_PATH . "users/" . $image['filename'];
			} else {
				$imagePath = IMAGES_PATH . "user-default.png";
			}
			$usersData[$key]['image'] = $imagePath;

			$accType = user::getAccType($acc_type);
			$accType = $accType['label'];

			$usersData[$key]['acc_type'] = $accType;
		}

		return $usersData;
	}

	public function getWaitingPayment() {

		$self_address = BASE_PATH . "management/payment";

		$header = "<table class='table table-bordered table-condensed'><thead><tr class='active'><th class='text-center' width='50'>#</th><th class='text-center'>Fullname</th><th class='text-center' width='200'>Username</th><th class='text-center' width='200'>Account Type</th><th class='text-center' width='200'>Payment Date</th><th class='text-center' width='100'>Status</th><th class='text-center' width='150'>Action</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$paymentExist = user::checkExist("user_payment", "status = '0'");

		if (!$paymentExist) {
			$content .= "<tr><td class ='text-center' colspan='7'>No waiting payment record.</td></tr>";
		} else {

			$page = $_GET['p'];

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 10;

			$from = (($current_page * $max_result) - $max_result);

			$paymentList_full = $this->db->select("user_payment", "*", "status = '0' ORDER BY id ASC");


			$total_row = count($paymentList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?wp=$prev_page'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			}

			if ($current_page >= 7) {
				$pagination .= "<li><a href='#'>1</a></li>";
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
			}

			for ($i = max(1, $current_page - 5); $i <= min($current_page + 5, $total_pages); $i++) {
				if (($current_page) == $i) {
					$pagination .= "<li class='active'><a href='#'>$i</a></li>";
				} else {
					$pagination .= "<li><a href='$self_address?wp=$i'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
				$pagination .= "<li><a href='#'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?wp=$next_page'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";


			$paymentList_limit = $this->db->select("user_payment", "*", "status = '0' ORDER BY id ASC LIMIT $from,$max_result");



			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='7'>No waiting payment record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($paymentList_limit as $value) {

					$user_id = $value['agent_id'];
					$id = $value['id'];

//                GET USER DATA
					$userdata = $this->db->select("user_accounts", "fullname,username,acc_type", "agent_id = '$user_id'", "fetch");

//                CONSTRUCT CONTENT
					$fullname = ucwords(strtolower($userdata['fullname']));
					$username = $userdata['username'];
					$acc_type = user::getAccType($userdata['acc_type']);
					$acc_type = $acc_type['label'];
					$payment_date = $value['payment_date'] . " " . $value['payment_time'];

					$status = "<abbr title='Waiting for review.'><span class='label label-warning'>Pending</span></abbr>";
					$review = BASE_PATH . "management/payment_review?agent_id=$user_id&i=$id";

					$content .= "<tr class='text-center warning'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$fullname</td>";
					$content .= "<td>$username</td>";
					$content .= "<td>$acc_type</td>";
					$content .= "<td>$payment_date</td>";
					$content .= "<td>$status</td>";
					$content .= "<td><a href='$review'><b class='fa fa-edit fa-fw'></b> Review</a></td>";



					$content .= "</tr>";
					$x++;
				}
			}
		}

		$footer = "</tbody></table>";
		$result = $header . $content . $footer . $pagination;

		echo json_encode($result);
	}

	public function getSummaryPayment() {

		$self_address = BASE_PATH . "management/payment";

		$header = "<table class='table table-bordered table-condensed'><thead><tr class='active'><th class='text-center' width='50'>#</th><th class='text-center'>Fullname</th><th class='text-center' width='200'>Username</th><th class='text-center' width='200'>Account Type</th><th class='text-center' width='200'>Payment Date</th><th class='text-center' width='100'>Status</th><th class='text-center' width='150'>Action</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$paymentExist = user::checkExist("user_payment", "status = '1' OR status = '2'");

		if (!$paymentExist) {
			$content .= "<tr><td class ='text-center' colspan='7'>No payment record.</td></tr>";
		} else {

			$searchItem = ($_GET['s'] != "") ? $_GET['s'] : NULL;

			if ($searchItem != NULL) {
				$searchTerm = "fullname LIKE '%$searchItem%' OR username LIKE '%$searchItem%' OR agent_id LIKE '%$searchItem%'";
				$getUserSearch = $this->db->select("user_accounts", "*", $searchTerm, "fetch");
				$search = "AND agent_id = '" . $getUserSearch['agent_id'] . "'";
			} else {
				$search = NULL;
			}


			$page = $_GET['p'];

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 10;

			$from = (($current_page * $max_result) - $max_result);

			$paymentList_full = $this->db->select("user_payment", "*", "(status = '1' OR status = '2') $search ORDER BY id ASC");


			$total_row = count($paymentList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			$searchLink = ($searchItem != NULL) ? "&s=$searchItem" : NULL;

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?sp=$prev_page$searchLink'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			}

			if ($current_page >= 7) {
				$pagination .= "<li><a href='#'>1</a></li>";
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
			}

			for ($i = max(1, $current_page - 5); $i <= min($current_page + 5, $total_pages); $i++) {
				if (($current_page) == $i) {
					$pagination .= "<li class='active'><a href='#'>$i</a></li>";
				} else {
					$pagination .= "<li><a href='$self_address?sp=$i$searchLink'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
				$pagination .= "<li><a href='#'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?sp=$next_page$searchLink'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";


			$paymentList_limit = $this->db->select("user_payment", "*", "(status = '1' OR status = '2') $search ORDER BY id ASC LIMIT $from,$max_result");



			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='7'>No payment record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($paymentList_limit as $value) {

					$user_id = $value['agent_id'];
					$id = $value['id'];

//                GET USER DATA
					$userdata = $this->db->select("user_accounts", "fullname,username,acc_type,payment", "agent_id = '$user_id'", "fetch");

//                CONSTRUCT CONTENT
					$fullname = ucwords(strtolower($userdata['fullname']));
					$username = $userdata['username'];
					$acc_type = user::getAccType($userdata['acc_type']);
					$acc_type = $acc_type['label'];
					$payment_date = $value['payment_date'] . " " . $value['payment_time'];

					switch ($userdata['payment']) {
						case "1":
							$status = "<abbr title='Waiting for clear payment.'><span class='label label-warning'>Pending</span></abbr>";
							$row = "warning";
							break;
						default:
							$status = "<abbr title='Payment clear.'><span class='label label-success'>Clear</span></abbr>";
							$row = "success";
							break;
					}


					$review = BASE_PATH . "management/payment_review?agent_id=$user_id&i=$id";

					$content .= "<tr class='text-center $row'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$fullname</td>";
					$content .= "<td>$username</td>";
					$content .= "<td>$acc_type</td>";
					$content .= "<td>$payment_date</td>";
					$content .= "<td>$status</td>";
					$content .= "<td><a href='$review'><b class='fa fa-edit fa-fw'></b> Review</a></td>";



					$content .= "</tr>";
					$x++;
				}
			}
		}

		$footer = "</tbody></table>";
		$result = $header . $content . $footer . $pagination;

		echo json_encode($result);
	}

	public function paymentDetails($agent_id, $id) {

		$user = $this->db->select("user_accounts", "fullname,ads_pin", "agent_id = '$agent_id'", "fetch");

		$data = $this->db->select("user_payment", "*", "agent_id = '$agent_id' AND id = '$id'", "fetch");
		$data['fullname'] = ucwords(strtolower($user['fullname']));
		$data['ads_pin'] = $user['ads_pin'];

		return $data;
	}

	public function payment_review_exec($data) {
		$response_array = array();

		$data['auth_datetime'] = date("Y-m-d H:i:s");

		$agent_id = $data['agent_id'];
		$payment_id = $data['id'];

		$userdata = user::getUserData("agent_id", $agent_id);

		foreach ($data as $key => $value) {
			if ($value == "") {
				$data[$key] = NULL;
			}
		}

//		Update Payment Data
		$payment_data['id'] = $payment_id;
		$payment_data['agent_id'] = $agent_id;
		$payment_data['status'] = $data['status'];
		$payment_data['auth_datetime'] = $data['auth_datetime'];
		$payment_data['remarks'] = $data['remarks'];

		$this->db->update("user_payment", $payment_data, "id = $payment_id and agent_id = $agent_id");

//		Update Agent Payment Status
		$pin_id = $data['ads_pin'];
		switch ($data['status']) {
			case "1":
				$agent_payment['payment'] = 1;

				break;
			case "2":
				$agent_payment['payment'] = 2;

				break;

			default:
				$pin_owner = $this->db->select("user_accounts", "available_pin, acc_type", "agent_id = '$pin_id'", "fetch");
				if (($pin_owner['acc_type'] != 'admin') and ( $pin_owner['acc_type'] != 'md')) {
					$pin_data['available_pin'] = $pin_owner['available_pin'] + 1;
					$this->db->update("user_accounts", $pin_data, "agent_id = '$pin_id'");
				}
				$agent_payment['payment'] = 0;
				break;
		}

		$this->db->update("user_accounts", $agent_payment, "agent_id = $agent_id");


//		Generate commission
		if ($data['status'] == 2) {
			$commData = array();
			$commData['agent_id'] = $data['agent_id'];
			$commData['acc_type'] = $userdata['acc_type'];
			$commData['date'] = $userdata['dt_join'];

			commission::generatePDICommission($commData);
			commission::generateGDICommission($commData);
			commission::generateGAICommission($commData);
			commission::generateAPRCommission($commData);
		}


//		Generate Email To Agent

		$redirectLink = BASE_PATH . "management/payment";
		if ($data['status'] == 2) {

			$payment_details = $this->db->select("user_payment", "id, agent_id, amount, payment_type, payment_for", "id = '$payment_id'", "fetch");

			$username = ucwords($userdata['username']);
			$fullname = ucwords(strtolower($userdata['fullname']));
			$email = $userdata['email'];
			$mobile = $userdata['mobile'];
			$order_no = $payment_details['id'] . "-" . $payment_details['agent_id'];
			$amount = "RM" . number_format($payment_details['amount']);
			$pay_method = user::getPaymentMethod($payment_details['payment_type'], "fetch");
			$pay_method = $pay_method['pay_method'];
			$auth_datetime = date("d M Y / H:i:s", strtotime($data['auth_datetime']));
			$payment_for = $payment_details['payment_for'];

//		Generate Email BODY

			$html = file_get_contents(BASE_PATH . 'email_template/payment_complete');
			$html = htmlspecialchars($html);

			$html = str_replace('[USERNAME]', $username, $html);
			$html = str_replace('[FULLNAME]', $fullname, $html);
			$html = str_replace('[EMAIL]', $email, $html);
			$html = str_replace('[MOBILE]', $mobile, $html);
			$html = str_replace('[ORDER_NO]', $order_no, $html);
			$html = str_replace('[AMOUNT]', $amount, $html);
			$html = str_replace('[PAY_METHOD]', $pay_method, $html);
			$html = str_replace('[AUTH_DATETIME]', $auth_datetime, $html);
			$html = str_replace('[PAYMENT_FOR]', $payment_for, $html);

			$html = html_entity_decode($html);

			$body = $html;

//			Send Email
			$mailer = new mailer();

			$mailer->IsSMTP(); // set mailer to use SMTP
			$mailer->Port = EMAIL_PORT;
			$mailer->Host = EMAIL_HOST;  // specify main and backup server
			$mailer->SMTPAuth = true; // turn on SMTP authentication
			$mailer->Username = NOREPLY_EMAIL;     // SMTP username
			$mailer->Password = NOREPLY_PASS;    // SMTP password
			$mailer->From = NOREPLY_EMAIL;
			$mailer->FromName = SUPPORT_NAME;
			$mailer->AddAddress($email);
			$mailer->IsHTML(true);

			$mailer->Subject = "Payment has been approved [" . $order_no . "]";
			$mailer->Body = $body;
			$mailer->Send();

			$response_array['r'] = "true";
			$response_array['msg'] = $redirectLink;
		}

		return $response_array;
	}

	public function getWithdrawList($status, $p_id, $p, $s) {

		$self_address = BASE_PATH . "management/withdrawal";

		($s != "") ? $s : NULL;

		$header = "<table class='table table-bordered table-condensed'><thead><tr><th class='text-center' width='50'>#</th><th class='text-center' width='150'>Agent ID</th><th class='text-center'>Holder Name</th><th class='text-center'>Bank Details</th><th class='text-center' width='150'>Date Request</th><th class='text-center' width='150'>Amount</th><th class='text-center' width='150'>Status</th><th class='text-center' width='150'>Action</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$status = ($status != "all") ? "status = '$status'" : NULL;

		$total_row = 0;
		$total_amount = 0;

		if (empty($s)) {
			$search = NULL;
		} else {
			$search = ($status != NULL) ? "AND (agent_id LIKE '%$s%' OR holder_name LIKE '%$s%')" : "status != '0' AND (agent_id LIKE '%$s%' OR holder_name LIKE '%$s%')";
		}

		$withdrawalExist = user::checkExist("user_withdrawal ", "$status $search");

		if (!$withdrawalExist) {
			$content .= "<tr><td class = 'text-center' colspan = '8'>No withdrawal record.</td></tr>";
		} else {

			$page = $p;

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 15;

			$from = (($current_page * $max_result) - $max_result);

			$withdrawalList_full = $this->db->select("user_withdrawal ", "* ", "$status $search ORDER BY id ASC");


			$total_row = count($withdrawalList_full);

			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class = 'pagination pagination-sm'>";

			if ($current_page > 1) {
				$pagination .= "<li><a href = '$self_address?$p_id=$prev_page'><span class = 'fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			} else {
				$pagination .= "<li class = 'disabled'><a href = '#'><span class = 'fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			}

			if ($current_page >= 7) {
				$pagination .= "<li><a href = '#'>1</a></li>";
				$pagination .= "<li class = 'disabled'><a href = '#'>..</a></li>";
			}

			for ($i = max(1, $current_page - 5); $i <= min($current_page + 5, $total_pages); $i++) {
				if (($current_page) == $i) {
					$pagination .= "<li class = 'active'><a href = '#'>$i</a></li>";
				} else {
					$pagination .= "<li><a href = '$self_address?$p_id=$i'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class = 'disabled'><a href = '#'>..</a></li>";
				$pagination .= "<li><a href = '#'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href = '$self_address?$p_id=$next_page'>Next <span class = 'fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class = 'disabled'><a href = '#'>Next <span class = 'fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";


			$withdrawalList_limit = $this->db->select("user_withdrawal ", "* ", "$status $search ORDER BY id ASC LIMIT $from, $max_result");



			if ($total_row == 0) {
				$content .= "<tr><td class = 'text-center' colspan = '8'>No withdrawal record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($withdrawalList_limit as $value) {

					$id = $value['id'];

//                CONSTRUCT CONTENT
					$agent_id = $value['agent_id'];
					$holder_name = $value['holder_name'];
					$bank_name = strtoupper($value['bank_name']);
					$acc_no = $value['acc_no'];
					$bank_details = $bank_name . "<br/>" . $acc_no;
					$format_date_request = date("d M Y-h:i A", strtotime($value['date_request']));
					$date_request = str_replace("- ", "<br/>", $format_date_request);
					$amount = $value['amount'];

					switch ($status) {
						case "-1":
							$status = "<abbr title = 'Withdrawal request rejected.'><span class = 'label label-danger'>Rejected</span></abbr>";
							break;
						case "1":
							$status = "<abbr title = 'Withdrawal request in process.'><span class = 'label label-info'>Process</span></abbr>";
							break;
						case "2":
							$status = "<abbr title = 'Withdrawal request complete.'><span class = 'label label-success'>Pending</span></abbr>";
							break;
						default:
							$status = "<abbr title = 'Waiting for review.'><span class = 'label label-warning'>Pending</span></abbr>";
							break;
					}

					$review = BASE_PATH . "management/withdrawal_review?agent_id = $agent_id&i = $id";

					$content .= "<tr class = 'text-center'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$agent_id</td>";
					$content .= "<td>$holder_name</td>";
					$content .= "<td>$bank_details</td>";
					$content .= "<td>$date_request</td>";
					$content .= "<td>RM" . number_format($amount) . "</td>";
					$content .= "<td>$status</td>";
					$content .= "<td><a href = '$review'><b class = 'fa fa-edit fa-fw'></b> Review</a></td>";

					$content .= "</tr>";

					$total_amount = $total_amount + $amount;

					$x++;
				}
			}
		}

		$total_agent = $total_row;
		$init = "<div class = 'row'><div class = 'col-xs-12'><h4>Total Withdrawal Amount: <b class = 'text-danger'>RM" . number_format($total_amount) . "</b> from <b class = 'text-danger'>$total_agent</b> agents.</h4></div></div>";

		$footer = "</tbody></table>";
		$result = $init . $header . $content . $footer . $pagination;

		echo json_encode($result);
	}

	public function ajaxAgentList($s, $p) {
		$self_address = BASE_PATH . "management/agentList";

		$header = "<table class='table table-bordered table-condensed small table-hover'><thead><tr class='active'><th class='text-center' width='50px'>No.</th><th class='text-center' width='100px'>Agent ID</th><th class='text-center' width='250px'>Fullname</th><th class='text-center' width='150px'>Username</th><th class='text-center' width='150px'>Sponsor</th><th class='text-center' width='150px'>Upline</th><th class='text-center' width='150px'>Acc. Type</th><th class='text-center' width='200px'>(Payment / Acc. Activation)</th><th class='text-center' width='150px'>Date Join</th><th class='text-center' width='150px'>Last Login</th><th class='text-center'>Action</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		if ($s == '') {
			$countAgentList = $this->db->count("user_accounts");
		} else {
			$countAgentList = $this->db->count("user_accounts", "(agent_id LIKE '%$s%' OR username LIKE '%$s%')");
		}



		if ($countAgentList == 0) {
			$content .= "<tr class='text-center'><td colspan='11'>No agent record found.</td></tr>";
			$total_row = 0;
		} else {

			$page = $p;

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 30;

			$from = (($current_page * $max_result) - $max_result);

			if ($s == '') {
				$agentList_full = $this->db->select("user_accounts", "*", "agent_id != '1000000' ORDER BY id DESC");
				$get_param = NULL;
			} else {
				$agentList_full = $this->db->select("user_accounts", "*", "(agent_id LIKE '%$s%' OR username LIKE '%$s%' OR fullname LIKE '%$s%') ORDER BY id DESC");
				$get_param = "&s=$s";
			}

			$total_row = count($agentList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?p=$prev_page$get_param'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			}

			if ($current_page >= 7) {
				$pagination .= "<li><a href='$self_address?p=1$get_param'>1</a></li>";
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
			}

			for ($i = max(1, $current_page - 5); $i <= min($current_page + 5, $total_pages); $i++) {
				if (($current_page) == $i) {
					$pagination .= "<li class='active'><a href='#'>$i</a></li>";
				} else {
					$pagination .= "<li><a href='$self_address?p=$i$get_param'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
				$pagination .= "<li><a href='$self_address?p=$total_pages$get_param'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?p=$next_page$get_param'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";

			if ($s == '') {
				$agentList_limit = $this->db->select("user_accounts", "*", "agent_id != '1000000' ORDER BY id DESC LIMIT $from,$max_result");
			} else {
				$agentList_limit = $this->db->select("user_accounts", "*", "(agent_id LIKE '%$s%' OR username LIKE '%$s%' OR fullname LIKE '%$s%') ORDER BY id DESC LIMIT $from,$max_result");
			}

			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='11'>No agent record found.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($agentList_limit as $value) {

					$agent_id = $value['agent_id'];
					$fullname = ucwords(strtolower($value['fullname']));
					$username = "<a target='_blank' href='" . BASE_PATH . "mynetwork/geneology?top=$agent_id'>" . $value['username'] . "</a>";

					$sponsor_id = $value['sponsor_id'];
					$sponsorData = $this->db->select("user_accounts", "username", "agent_id = $sponsor_id", "fetch");
					$sponsor = "<a target='_blank' href='" . BASE_PATH . "mynetwork/geneology?top=$sponsor_id'>" . $sponsorData['username'] . "</a>";

					$upline_id = $value['lv1'];
					$uplineData = $this->db->select("user_accounts", "username", "agent_id = $upline_id", "fetch");
					$upline = "<a target='_blank' href='" . BASE_PATH . "mynetwork/geneology?top=$upline_id'>" . $uplineData['username'] . "</a>";

					$acc_type = $value['acc_type'];
					$acc_type = user::getAccType($acc_type);
					$acc_type = $acc_type['label'];

					$payment = $value['payment'];

					switch ($payment) {
						case 0:
							$payment = "<span class='label label-danger'>Not Complete</span>";

							break;
						case 1:
							$payment = "<span class='label label-warning'>Pending</span>";

							break;
						case 2:

							$payment = "<span class='label label-success'>Complete</span>";
							break;

						default:
							$payment = "<span class='label label-danger'>Rejected</span>";
							break;
					}

					$activatation = $value['activate'];

					switch ($activatation) {
						case 1:
							$activatation = "<span class='label label-success'>Activate</span>";

							break;

						default:
							$activatation = "<span class='label label-danger'>Not Activate</span>";
							break;
					}

					$date_join = date("d M Y / h:i A", strtotime($value['dt_join']));
					$last_login = ($value['last_login'] != NULL) ? date("d M Y / h:i A", strtotime($value['last_login'])) : "Never Login";

					$action = "<a class='btn btn-xs btn-info unavailable-link' href='#'>Details</a> ";
					$action .= "<a class='btn btn-xs btn-warning unavailable-link' href='#'>Payment</a> ";
					$action .= "<a class='btn btn-xs btn-success' href='" . BASE_PATH . "management/agentUpgrade?agent_id=$agent_id'>Upgrade</a> ";
					$action .= "<a class='btn btn-xs btn-info' target='_blank' href='" . BASE_PATH . "management/agentCommission?agent_id=$agent_id'>Commission</a> ";

//                CONSTRUCT CONTENT
//					
//
					$content .= "<tr class='text-center'>";
//
					$content .= "<td>$x</td>";
					$content .= "<td>$agent_id</td>";
					$content .= "<td class='text-left'>$fullname</td>";
					$content .= "<td>$username</td>";
					$content .= "<td>$sponsor</td>";
					$content .= "<td>$upline</td>";
					$content .= "<td>$acc_type</td>";
					$content .= "<td>$payment / $activatation</td>";
					$content .= "<td>$date_join</td>";
					$content .= "<td>$last_login</td>";
					$content .= "<td>$action</td>";
//
					$content .= "</tr>";
					$x++;
				}
			}
		}

		$footer = "</tbody></table>";

		$init = "<div class='row'><div class='col-sm-4'>Total record: $total_row</div></div>";

		$result = $init . $header . $content . $footer . $pagination;

		echo json_encode($result);
	}

	public function commissionList($type, $month, $agent_id) {
		$self_address = BASE_PATH . "management/agentCommission";

		$header = "<table class='table table-bordered table-condensed'><thead> <tr><th class='text-center' width='50'>#</th><th class='text-center' width='100'>Type</th><th class='text-center'>Subject</th><th class='text-center' width='250'>Amount</th><th class='text-center' width='250'>Date</th><th class='text-center' width='250'>Date Release</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$checkCommission = $this->db->count("user_commissions", "agent_id = '$agent_id' AND f = 0");

		if ($checkCommission == 0) {
			$content .= "<tr class='text-center'><td colspan='6'>No commission record found.</td></tr>";
		} else {

			$ftype = ($type == "all") ? NULL : $type;
			$fmonth = ($month == "all") ? NULL : date("Y-m", strtotime($month));

			$get_type = ($ftype == NULL) ? NULL : "&type=$ftype";
			$get_month = ($fmonth == NULL) ? NULL : "&month=" . date("M Y", strtotime($fmonth));
			$get_param = $get_type . $get_month;

			if (($ftype != NULL) AND ( $fmonth != NULL)) {
				$SQL = "(type = '$ftype' AND date_release LIKE '%$fmonth% AND f = 0')";
			} elseif (($ftype == NULL) AND ( $fmonth != NULL)) {
				$SQL = "date_release LIKE '%$fmonth%' AND f = 0";
			} elseif (($ftype != NULL) AND ( $fmonth == NULL)) {
				$SQL = "type = '$ftype' AND f = 0";
			} else {
				$SQL = "f = 0";
			}

			$sql_cond = ($SQL == NULL) ? NULL : "AND $SQL";

			$page = $_GET['p'];

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 30;

			$from = (($current_page * $max_result) - $max_result);

			if (($ftype == NULL) AND ( $fmonth == NULL)) {
				$commissionList_full = $this->db->select("user_commissions", "*", "agent_id = '$agent_id' AND f = 0 ORDER BY date_release DESC");
			} else {
				$commissionList_full = $this->db->select("user_commissions", "*", "agent_id = '$agent_id' $sql_cond ORDER BY date_release DESC");
			}

			$total_row = count($commissionList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?p=$prev_page$get_param&agent_id=$agent_id'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			}

			if ($current_page >= 7) {
				$pagination .= "<li><a href='$self_address?p=1&agent_id=$agent_id'>1</a></li>";
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
			}

			for ($i = max(1, $current_page - 5); $i <= min($current_page + 5, $total_pages); $i++) {
				if (($current_page) == $i) {
					$pagination .= "<li class='active'><a href='#'>$i</a></li>";
				} else {
					$pagination .= "<li><a href='$self_address?p=$i$get_param&agent_id=$agent_id'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
				$pagination .= "<li><a href='$self_address?p=$total_pages&agent_id=$agent_id'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?p=$next_page$get_param&agent_id=$agent_id'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";

			if (($ftype == NULL) AND ( $fmonth == NULL)) {
				$commissionList_limit = $this->db->select("user_commissions", "*", "agent_id = '$agent_id' ORDER BY date_release DESC LIMIT $from,$max_result");
			} else {
				$commissionList_limit = $this->db->select("user_commissions", "*", "agent_id = '$agent_id' $sql_cond ORDER BY date_release DESC LIMIT $from,$max_result");
			}

			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='6'>No commission record found.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($commissionList_limit as $value) {

//                CONSTRUCT CONTENT
					$commtype = strtoupper($value['type']);
					$subject = $value['subject'];
					$amount = "RM" . $value['amount'];
					$date = date("d/m/Y", strtotime($value['date']));
					$date_release = date("d/m/Y", strtotime($value['date_release']));

					$content .= "<tr class='text-center'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$commtype</td>";
					$content .= "<td>$subject</td>";
					$content .= "<td>$amount</td>";
					$content .= "<td>$date</td>";
					$content .= "<td>$date_release</td>";

					$content .= "</tr>";
					$x++;
				}
			}
		}

		$footer = "</tbody></table>";

		$result = $header . $content . $footer . $pagination;

		echo json_encode($result);
	}

	public function agentUpgrade_exec($data) {
		$userData = user::getUserData("agent_id", $data['agent_id']);

		$agent_id = $data['agent_id'];

		$payment_data = array();
		$payment_data['agent_id'] = $agent_id;
		$payment_data['payment_for'] = "[UPGRADE] " . $data['payment_for'];
		$payment_data['payment_date'] = $data['payment_date'];
		$payment_data['payment_time'] = $data['payment_time'];
		$payment_data['from_acc'] = $data['from_acc'];
		$payment_data['to_acc'] = $data['to_acc'];
		$payment_data['payment_type'] = $data['payment_type'];
		$payment_data['ref'] = $data['ref'];
		$payment_data['payment_price'] = $data['payment_price'];
		$payment_data['amount'] = $data['payment_price'];
		$payment_data['payment_bal'] = 0;
		$payment_data['date_submit'] = $data['date_submit'];
		$payment_data['auth_datetime'] = $data['date_submit'];
		$payment_data['remarks'] = $data['remarks'];
		$payment_data['status'] = 2;

		$upgrade_data = array();
		$upgrade_data['ads_pin_limit'] = $data['ads_pin_limit'];
		$upgrade_data['available_pin'] = $data['ads_pin_limit'] + $userData['available_pin'];
		$upgrade_data['acc_type'] = $data['acc_type'];
		$upgrade_data['payment'] = 2;



		$response_array = array();
		$error = array();

		$curr_acc_type = $userData['acc_type'];

		switch ($data['acc_type']) {
			case "aa":
				if ($curr_acc_type == "aa" or $curr_acc_type == "ad" or $curr_acc_type == "ed" or $curr_acc_type == "ep") {
					$error['msg'] = "<b>Account To Upgrade</b> must be higher then current account.)";
				}

				break;
			case "ad":
				if ($curr_acc_type == "ad" or $curr_acc_type == "ed" or $curr_acc_type == "ep") {
					$error['msg'] = "<b>Account To Upgrade</b> must be higher then current account.)";
				}

				break;
			case "ed":
				if ($curr_acc_type == "ed" or $curr_acc_type == "ep") {
					$error['msg'] = "<b>Account To Upgrade</b> must be higher then current account.)";
				}

				break;

			default:
				break;
		}

		if (count($error) != 0) {
			$response_array['r'] = "false";
			$response_array['msg'] = $error['msg'];
		} else {
			//		Insert payment upgrade
			foreach ($payment_data as $key => $value) {
				if ($value == "") {
					$payment_data[$key] = NULL;
				}
			}
			$r_payment = $this->db->insert("user_payment", $payment_data);
//		Upgrade agent account
			foreach ($upgrade_data as $key => $value) {
				if ($value == "") {
					$upgrade_data[$key] = NULL;
				}
			}
			$r_upgrade = $this->db->update("user_accounts", $upgrade_data, "agent_id = $agent_id");
//		Generate Commission

			$commData = array();
			$commData['agent_id'] = $data['agent_id'];
			$commData['acc_type'] = $data['acc_type'];
			$commData['date'] = $data['payment_date'];

			$r_pdi = commission::generatePDICommission($commData, TRUE);
			$r_gdi = commission::generateGDICommission($commData, TRUE);
			$r_gai = commission::generateGAICommission($commData, TRUE);

//		TODO: Generate email for upgraded agent

			$response_array['r'] = "true";
			$response_array['msg'] = BASE_PATH . "management/upgradeResult?agent_id=$agent_id&payment=$r_payment&upgrade=$r_upgrade&pdi=$r_pdi&gdi=$r_gdi&gai=$r_gai";
		}

		return $response_array;
	}

	public function addSupplier_exec($data) {
		$response_array = array();

		$data['agent_id'] = $data['agent_id'];
		$data['supplier_id'] = user::generateSupplierID();

		$data['comp_name'] = ucwords($data['comp_name']);
		$data['comp_reg_no'] = strtoupper($data['comp_reg_no']);
		$data['comp_address'] = ucwords($data['comp_address']);

		if ($data['comp_state'] != "oth") {
			unset($data['state_other']);
		}

		$data['token'] = hash::create("sha256", $data['supplier_id'], $data['comp_email']);


		$data['website'] = strtolower($data['website']);
		$data['website'] = str_replace("http://", "", $data['website']);
		$data['website'] = str_replace("https://", "", $data['website']);

		$data['tag'] = strtolower(str_replace(", ", ",", $data['tag']));
		$data['p_fullname'] = ucwords(strtolower($data['p_fullname']));
		$data['p_pos'] = ucwords(strtolower($data['p_pos']));

		$agent_id = $data['agent_id'];

		for ($x = 1; $x <= 5; $x++) {
			$userID = $this->db->select("user_accounts", "sponsor_id", "agent_id = $agent_id", "fetch");

			$agent_id = $userID['sponsor_id'];
			$data['lv' . $x] = $agent_id;
		}

		foreach ($data as $key => $value) {
			if ($value == "") {
				$data[$key] = NULL;
			}
		}

		$insert = $this->db->insert("user_suppliers", $data);

		if (!$insert) {
			$response_array['r'] = "false";
			$response_array['msg'] = "Oopps! Looks like there is some technical error while process your supplier registration. Please re-submit the form or refresh your browser.";
		} else {

			$response_array['r'] = "true";
			$response_array['msg'] = BASE_PATH . "management/supplier?r=success&t=addnew&a=" . $data['token'];
		}


		return $response_array;
	}

	public function ajaxSupplierList() {

		$self_address = BASE_PATH . "management/supplier";

		$header = "<table class='table table-bordered table-condensed'><thead><tr><th class='text-center' width='50px'>#</th><th class='text-center' width='150px'>Agent ID</th><th class='text-center' width='150px'>Supplier ID</th><th class='text-center' width='100px'>Type</th><th class='text-center' width='250px'>Supplier Name</th><th class='text-center' width='150px'>Category</th><th class='text-center' width='150px'>State, Country</th><th class='text-center' width='150px'>Advertisement</th><th class='text-center' width='150px'>Status</th><th class='text-center' width='250px'>Action</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$listExist = user::checkExist("user_suppliers");

		if (!$listExist) {
			$content .= "<tr><td class ='text-center' colspan='9'>No supplier record.</td></tr>";
		} else {

			if (isset($_REQUEST['s'])) {

				$s = $_GET['s'];

				if ($_GET['s'] != "") {
					$searchItm = $s;
					$searchSQL = " AND (comp_name LIKE '%$searchItm%')";
					$get_search = "&s=$searchItm";
				} else {
					$searchItm = NULL;
					$searchSQL = NULL;
					$get_search = NULL;
				}
			} else {
				$searchItm = NULL;
				$searchSQL = NULL;
				$get_search = NULL;
			}

			$page = $_GET['p'];

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 15;

			$from = (($current_page * $max_result) - $max_result);

			if ($searchItm == NULL) {
				$supplierList_full = $this->db->select("user_suppliers", "*", "agent_id != 'NULL' ORDER BY id DESC");
			} else {
				$supplierList_full = $this->db->select("user_suppliers", "*", "agent_id != 'NULL' $searchSQL ORDER BY id DESC");
			}
//
			$total_row = count($supplierList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?p=$prev_page$get_search'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			}

			if ($current_page >= 7) {
				$pagination .= "<li><a href='$self_address?p=1$get_search'>1</a></li>";
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
			}

			for ($i = max(1, $current_page - 5); $i <= min($current_page + 5, $total_pages); $i++) {
				if (($current_page) == $i) {
					$pagination .= "<li class='active'><a href='#'>$i</a></li>";
				} else {
					$pagination .= "<li><a href='$self_address?p=$i$get_search'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
				$pagination .= "<li><a href='$self_address?p=$total_pages$get_search'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?p=$next_page$get_search'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";


			if ($searchItm == NULL) {
				$supplierList_limit = $this->db->select("user_suppliers", "*", "agent_id != 'NULL' ORDER BY id DESC LIMIT $from,$max_result");
			} else {
				$supplierList_limit = $this->db->select("user_suppliers", "*", "agent_id != 'NULL' $searchSQL ORDER BY id DESC LIMIT $from,$max_result");
			}


			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='9'>No supplier record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($supplierList_limit as $value) {


//                CONSTRUCT CONTENT
					$agent_id = $value['agent_id'];
					$agent = user::getUserData("agent_id", $agent_id);

					$supplier_id = $value['supplier_id'];

					switch ($value['type']) {
						case 1:
							$type = "Paid";
							$color = "bg-highlight";
							break;

						default:
							$type = "Free";
							$color = NULL;
							break;
					}

					$name = ucwords(strtolower($value['comp_name']));

					$categotyData = $this->db->select("category", "*", "id = '" . $value['category'] . "'", "fetch");
					$category = $categotyData['category'] . " - " . $categotyData['subcategory'];

					if ($value['comp_state'] == "oth") {
						$state = $value['state_other'];
					} else {
						$stateData = user::getStates($value['comp_country']);
						$statesArr = $stateData[0]['states'];
						$statesArr = json_decode($statesArr);
						$statesArr = get_object_vars($statesArr);

						foreach ($statesArr as $key2 => $value2) {
							if ($key2 == $value['comp_state']) {
								$state = $value2;
							}
						}
					}

					$country = $this->db->select("country", "*", "code = '" . $value['comp_country'] . "'", "fetch");

					$stateCountry = $state . ", " . $country['name'];

					$count_ads = $this->db->count("advertisement_view", "supplier_id = $supplier_id");
					$ads_count = "<a class='btn btn-xs btn-link' href='" . BASE_PATH . "management/advertisement?sid=$supplier_id&aid=$agent_id' title='View all advertisement from this supplier.'>$count_ads</a>";
					$add_ads_btn = "<a class='btn btn-xs btn-link unavailable-link' href='" . BASE_PATH . "management/addAds?sid=$supplier_id' title='Add advertisement for this supplier.'><i class='fa fa-plus-square fa-fw'></i> Add</a>";
					$total_ads = $ads_count . " | " . $add_ads_btn;

					$status = ($value['status'] == 0) ? "<span class='text-danger'>Waiting to verify</span>" : "<span class='text-success'>Verified</span>";

					$action = "<div class='col-xs-12'><a class='btn btn-xs btn-info unavailable-link' href='" . BASE_PATH . "management/supplierDetails?sid=$supplier_id' title='View supplier details.'><i class='fa fa-file-text fa-fw'></i> Details</a> <a class='btn btn-xs btn-warning unavailable-link' href='" . BASE_PATH . "management/updateSupplier?sid=$supplier_id' title='Update supplier details.'><i class='fa fa-edit fa-fw'></i> Update</a></div>";

					$content .= "<tr class='text-center $color'>";

					$content .= "<td>$x</td>";
					$content .= "<td>" . $agent['username'] . "</td>";
					$content .= "<td>$supplier_id</td>";
					$content .= "<td>$type</td>";
					$content .= "<td>$name</td>";
					$content .= "<td>$category</td>";
					$content .= "<td>$stateCountry</td>";
					$content .= "<td>$total_ads</td>";
					$content .= "<td>$status</td>";
					$content .= "<td>$action</td>";

					$content .= "</tr>";
					$x++;
				}
			}
		}

		$footer = "</tbody></table>";

		$result = $header . $content . $footer . $pagination;



		return $result;
	}

	public function advertisementList() {
		$self_address = BASE_PATH . "management/advertisement";

		if (!isset($_REQUEST['s'])) {
			$_GET['s'] = NULL;
		}
		if (!isset($_REQUEST['p'])) {
			$_GET['p'] = 1;
		}


		$header = "<table class='table table-bordered table-condensed'><thead><tr><th class='text-center' width='50px'>#</th><th class='text-center' width='150px'>Ads ID</th><th class='text-center' width='150px'>Ads Pin</th><th class='text-center' >Supplier Name</th><th class='text-center' >Ads Name</th><th class='text-center' width='150px'>Document Date</th><th class='text-center' width='150px'>Receive Date</th><th class='text-center' width='150px'>Status</th><th class='text-center' width='150px'>Start Date</th><th class='text-center' width='150px'>Expiry Date</th><th class='text-center' width='300px'></th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$listExist = user::checkExist("advertisement_view");

		if (!$listExist) {
			$content .= "<tr><td class ='text-center' colspan='11'>No advertisement record.</td></tr>";
		} else {

			if (isset($_REQUEST['s'])) {

				$s = $_GET['s'];

				if ($_GET['s'] != "") {
					$searchItm = $s;
					$searchSQL = " AND (ads_name LIKE '%$searchItm%') OR (supplier_id LIKE '%$searchItm%') OR (ads_id LIKE '%$searchItm%')";
					$get_search = "&s=$searchItm";
				} else {
					$searchItm = NULL;
					$searchSQL = NULL;
					$get_search = NULL;
				}
			} else {
				$searchItm = NULL;
				$searchSQL = NULL;
				$get_search = NULL;
			}

			$page = $_GET['p'];

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 15;

			$from = (($current_page * $max_result) - $max_result);

			if (isset($_REQUEST['sid']) AND isset($_REQUEST['aid'])) {
				$aid = $_GET['aid'];
				$sid = $_GET['sid'];
				$cond = "agent_id = '$aid' AND supplier_id = '$sid'";
			} else {
				$cond = "agent_id != 'NULL'";
			}

			if ($searchItm == NULL) {
				$advertisementList_full = $this->db->select("advertisement_view", "*", "$cond ORDER BY id DESC");
			} else {
				$advertisementList_full = $this->db->select("advertisement_view", "*", "$cond $searchSQL ORDER BY id DESC");
			}
//
			$total_row = count($advertisementList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?p=$prev_page$get_search'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			}

			if ($current_page >= 7) {
				$pagination .= "<li><a href='$self_address?p=1$get_search'>1</a></li>";
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
			}

			for ($i = max(1, $current_page - 5); $i <= min($current_page + 5, $total_pages); $i++) {
				if (($current_page) == $i) {
					$pagination .= "<li class='active'><a href='#'>$i</a></li>";
				} else {
					$pagination .= "<li><a href='$self_address?p=$i$get_search'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
				$pagination .= "<li><a href='$self_address?p=$total_pages$get_search'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?p=$next_page$get_search'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";


			if ($searchItm == NULL) {
				$advertisementList_limit = $this->db->select("advertisement_view", "*", "$cond ORDER BY id DESC LIMIT $from,$max_result");
			} else {
				$advertisementList_limit = $this->db->select("advertisement_view", "*", "$cond $searchSQL ORDER BY id DESC LIMIT $from,$max_result");
			}


			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='11'>No advertisement record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($advertisementList_limit as $value) {


//                CONSTRUCT CONTENT
					$ads_id = $value['ads_id'];
					$ads_pin = ($value['ads_pin']) ? "Yes" : "No";

					$supplier_data = user::getSupplierData("supplier_id", $value['supplier_id']);
					$supplier_name = "<a href='" . BASE_PATH . "management/supplier?s=" . $supplier_data['comp_name'] . "'>" . $supplier_data['comp_name'] . "</a>";

					$ads_name = $value['ads_name'];

					$doc_date = ($value['date_doc'] != NULL) ? date("d M Y", strtotime($value['date_doc'])) : "N/A";
					$receive_date = ($value['date_receive'] != NULL) ? date("d M Y", strtotime($value['date_receive'])) : "N/A";

					$ads_status = $value['ads_status'];

					$date_start = ($value['date_start'] != NULL) ? date("d M Y", strtotime($value['date_start'])) : "N/A";
					$date_end = ($value['date_end'] != NULL) ? date("d M Y", strtotime($value['date_end'])) : "N/A";

					$action = "<button type='button' class='btn btn-primary btn-xs btn-details-toggles' data-toggle='modal' data-target='#detailsModal' data-adsid='$ads_id' data-url='".BASE_PATH."management/ajaxAdsDetails'><i class='fa fa-file-text fa-fw'></i> Details</button>";

					$content .= "<tr class='text-center'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$ads_id</td>";
					$content .= "<td>$ads_pin</td>";
					$content .= "<td>$supplier_name</td>";
					$content .= "<td>$ads_name</td>";
					$content .= "<td>$doc_date</td>";
					$content .= "<td>$receive_date</td>";
					$content .= "<td>$ads_status</td>";
					$content .= "<td>$date_start</td>";
					$content .= "<td>$date_end</td>";
					$content .= "<td class='details'>$action</td>";

					$content .= "</tr>";
					$x++;
				}
			}
		}

		$footer = "</tbody></table>";

		$result = $header . $content . $footer . $pagination;



		return $result;
	}
	
	public function ajaxAdsDetails($ads_id) {

		$ads_data = user::getAdsData("ads_id", "$ads_id");
		$supplier_data = user::getSupplierData("supplier_id", $ads_data['supplier_id']);

		$data = array();
		$data['ads_name'] = $ads_data['ads_name'];
		$data['comp_name'] = $supplier_data['comp_name'];
		$data['day_left'] = floor((strtotime($ads_data['date_end']) - time()) / (60 * 60 * 24)) . " days";
		$data['period'] = $ads_data['period'] . " month";
		$data['payment'] = "RM " . number_format($ads_data['payment']);
		$data['commission'] = "RM " . number_format($ads_data['commission']);
		$data['link'] = ($ads_data['link'] != "#") ? "<a target='_blank' href='" . $ads_data['link'] . "'>" . $ads_data['link'] . "</a>" : "#";
		$data['hashtag'] = ($ads_data['hashtag'] != NULL) ? "<a target='_blank' href='https://www.facebook.com/hashtag/" . $ads_data['hashtag'] . "'>" . $ads_data['hashtag'] . "</a>" : "N/A";
		$data['adsImg'] = ($ads_data['img_lg'] != NULL) ? "<img src='". BASE_PATH . "public/images/ads/" . $ads_data['id'] . "/" . $ads_data['img_lg'] ."' width='100%'/>" : "This advertisement is not ready for viewing.";

		return $data;
	}

}
