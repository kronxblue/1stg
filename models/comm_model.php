<?php

class comm_model extends model {

	function __construct() {
		parent::__construct();
		session::init();
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

	public function commissionList($type, $month) {
		$self_address = BASE_PATH . "comm";

		$header = "<table class='table table-bordered table-condensed'><thead> <tr><th class='text-center' width='50'>#</th><th class='text-center' width='100'>Type</th><th class='text-center'>Subject</th><th class='text-center' width='250'>Amount</th><th class='text-center' width='250'>Date</th><th class='text-center' width='250'>Date Release</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$agent_id = session::get(AGENT_SESSION_NAME);

		$checkCommission = $this->db->count("user_commissions", "agent_id = '$agent_id'");

		if ($checkCommission == 0) {
			$content .= "<tr class='text-center'><td colspan='6'>No commission record found.</td></tr>";
		} else {

			$ftype = ($type == "all") ? NULL : $type;
			$fmonth = ($month == "all") ? NULL : date("Y-m", strtotime($month));

			$get_type = ($ftype == NULL) ? NULL : "&type=$ftype";
			$get_month = ($fmonth == NULL) ? NULL : "&month=" . date("M Y", strtotime($fmonth));
			$get_param = $get_type . $get_month;

			if (($ftype != NULL) AND ( $fmonth != NULL)) {
				$SQL = "(type = '$ftype' AND date_release LIKE '%$fmonth%')";
			} elseif (($ftype == NULL) AND ( $fmonth != NULL)) {
				$SQL = "date_release LIKE '%$fmonth%'";
			} elseif (($ftype != NULL) AND ( $fmonth == NULL)) {
				$SQL = "type = '$ftype'";
			} else {
				$SQL = NULL;
			}

			$sql_cond = ($SQL == NULL) ? NULL : "AND $SQL";

			$page = $_GET['p'];

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 30;

			$from = (($current_page * $max_result) - $max_result);

			if (($ftype == NULL) AND ( $fmonth == NULL)) {
				$commissionList_full = $this->db->select("user_commissions", "*", "agent_id = '$agent_id' ORDER BY date_release DESC");
			} else {
				$commissionList_full = $this->db->select("user_commissions", "*", "agent_id = '$agent_id' $sql_cond ORDER BY date_release DESC");
			}

			$total_row = count($commissionList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?p=$prev_page$get_param'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
			}

			if ($current_page >= 7) {
				$pagination .= "<li><a href='$self_address?p=1'>1</a></li>";
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
				$pagination .= "<li><a href='$self_address?p=$total_pages'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?p=$next_page$get_param'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
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
				$content .= "<tr><td class ='text-center' colspan='5'>No commission record found.</td></tr>";
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

	public function totalCommission($agent_id, $commType, $monthList) {
		$commListArr = array();
		$totalMonthlyComm = 0;

		$i = 0;
		foreach ($monthList as $value) {
			$start_date = date("Y-m-d H:i:s", strtotime($value . "-1"));
			$end_date = date("Y-m-t H:i:s", strtotime($value));

			$commListArr[$i] = $this->db->select("user_commissions", "amount", "agent_id = '$agent_id' AND type = '$commType' AND (date_release >= '$start_date' AND date_release <= '$end_date')");

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

	public function getCommission($agent_id, $commType, $param = NULL, $sort = "DESC") {

		$where = ($param != NULL) ? "AND ($param)" : NULL;

		$data = $this->db->select("user_commissions", "*", "agent_id = '$agent_id' AND type = '$commType' $where ORDER BY id $sort");

		return $data;
	}

	public function getCommissionStatement($agent_id, $type) {
		$linkPath = strtolower($type);
		$linkPath = str_replace(" ", "_", $linkPath);

		$self_address = BASE_PATH . "comm/$linkPath";

		$header = "<table class='table table-bordered table-condensed'><thead><tr class='active'><th class='text-center'>#</th><th class='text-center'>Subject</th><th class='text-center' width='250'>Date Release</th><th class='text-center' width='250'>Commission</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$commissionExist = user::checkExist("user_commissions", "agent_id = '$agent_id' AND type = '$type'");

		if (!$commissionExist) {
			$content .= "<tr><td class ='text-center' colspan='7'>No commission record.</td></tr>";
		} else {

			$filterItm = ($_GET['f'] != "") ? $_GET['f'] : NULL;

			if ($filterItm != NULL) {
				$filter = "AND date_release LIKE '%$filterItm%'";
			} else {
				$filter = NULL;
			}


			$page = $_GET['p'];

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 50;

			$from = (($current_page * $max_result) - $max_result);

			$commissionList_full = $this->db->select("user_commissions", "*", "(agent_id = '$agent_id' AND type = '$type') $filter ORDER BY id DESC");


			$total_row = count($commissionList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			$filterLink = ($filterItm != NULL) ? "&s=$filterItm" : NULL;

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?p=$prev_page$filterLink'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
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
					$pagination .= "<li><a href='$self_address?p=$i$filterLink'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
				$pagination .= "<li><a href='#'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?p=$next_page$filterLink'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";


			$commissionsList_limit = $this->db->select("user_commissions", "*", "(agent_id = '$agent_id' AND type = '$type') $filter ORDER BY id DESC LIMIT $from,$max_result");



			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='7'>No commission record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;
				$total_commission = 0;

				foreach ($commissionsList_limit as $value) {

//                CONSTRUCT CONTENT
					$subject = $value['subject'];
					$amount = $value['amount'];
					$date_release = date("d M Y", strtotime($value['date_release']));

					$content .= "<tr class='text-center'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$subject</td>";
					$content .= "<td>$date_release</td>";
					$content .= "<td>RM" . number_format($amount) . "</td>";

					$content .= "</tr>";

					$total_commission = $total_commission + $amount;
					$x++;
				}

				$content .= "<tr class='text-center active'>";
				$content .= "<th class='text-center' colspan='3'>Total Commission</th>";
				$content .= "<th class='text-center'>RM" . number_format($total_commission) . "</th>";
				$content .= "</tr>";
			}
		}

		$footer = "</tbody></table>";
		$result = $header . $content . $footer . $pagination;

		echo json_encode($result);
	}

	public function getWithdrawalStatement($agent_id) {

		$self_address = BASE_PATH . "comm/withdrawal";

		$header = "<table class='table table-bordered table-condensed'><thead><tr><th class='text-center' width='50'>#</th><th class='text-center' width='150'>Date Request</th><th class='text-center'>Acount Details</th><th class='text-center' width='150'>Amount</th><th class='text-center' width='300'>Remarks</th><th class='text-center' width='150'>Status</th><th class='text-center' width='100'>Action</th></tr></thead> <tbody>";
		$content = "";
		$pagination = "";

		$recordExist = user::checkExist("user_withdrawal", "agent_id = '$agent_id'");

		if (!$recordExist) {
			$content .= "<tr><td class ='text-center' colspan='7'>No withdrawal record.</td></tr>";
		} else {

			$filterItm = ($_GET['f'] != "") ? $_GET['f'] : NULL;

			if ($filterItm != NULL) {
				$filter = "AND date_request LIKE '%$filterItm%'";
			} else {
				$filter = NULL;
			}


			$page = $_GET['p'];

			$current_page = $page;

			$prev_page = ($current_page - 1);
			$next_page = ($current_page + 1);

			$max_result = 30;

			$from = (($current_page * $max_result) - $max_result);

			$withdrawalList_full = $this->db->select("user_withdrawal", "*", "agent_id = '$agent_id' $filter ORDER BY id DESC");


			$total_row = count($withdrawalList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			$filterLink = ($filterItm != NULL) ? "&s=$filterItm" : NULL;

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?p=$prev_page$filterLink'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
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
					$pagination .= "<li><a href='$self_address?p=$i$filterLink'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
				$pagination .= "<li><a href='#'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?p=$next_page$filterLink'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";


			$withdrawalList_limit = $this->db->select("user_withdrawal", "*", "agent_id = '$agent_id' $filter ORDER BY id DESC LIMIT $from,$max_result");



			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='7'>No withdrawal record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;
				$total_withdrawal = 0;

				foreach ($withdrawalList_limit as $value) {

//                CONSTRUCT CONTENT
					$id = $value['id'];
					$datetime = date("d M Y-h:i A", strtotime($value['date_request']));
					$date_request = str_replace("-", "<br/>", $datetime);

					$holder_name = $value['holder_name'];
					$bank_name = strtoupper($value['bank_name']);
					$acc_no = $value['acc_no'];
					$account_details = $holder_name . "<br/>" . $bank_name . " - " . $acc_no;

					$amount = $value['amount'];
					$remarks = $value['remarks'];

					$status_code = $value['status'];
					$date_review = date("d M Y", strtotime($value['date_review']));

					switch ($status_code) {
						case "-1":
							$status = "<abbr title='Withdrawal request rejected.'><span class='label label-danger'>Rejected</span></abbr><br/>$date_review";
							$action = "";
							break;
						case "1":
							$status = "<abbr title='Withdrawal request in process.'><span class='label label-info'>Process</span></abbr><br/>$date_review";
							$action = "";
							break;
						case "2":
							$status = "<abbr title='Payment complete.'><span class='label label-success'>Success</span></abbr><br/>$date_review";
							$action = "";
							break;

						default:
							$status = "<abbr title='Waiting for review process.'><span class='label label-warning'>Pending</span></abbr>";
							$action = "<a class='btn btn-link btn-cancel-withdraw' data-no='$x' data-id='$id' href='" . BASE_PATH . "comm/cancelWithdraw'>Cancel</a>";
							break;
					}

					$content .= "<tr class='text-center'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$date_request</td>";
					$content .= "<td>$account_details</td>";
					$content .= "<td>RM" . number_format($amount) . "</td>";
					$content .= "<td>$remarks</td>";
					$content .= "<td>$status</td>";
					$content .= "<td>$action</td>";

					$content .= "</tr>";

					if ($value['status'] == "2") {
						$total_withdrawal = $total_withdrawal + $amount;
					}

					$x++;
				}

				$content .= "<tr class='active'>";
				$content .= "<th class='text-center' colspan='3'>Total Successful Withdrawal</th>";
				$content .= "<th class='text-center'>RM" . number_format($total_withdrawal) . "</th>";
				$content .= "<th class='text-center' colspan='3'></th>";
				$content .= "</tr>";
			}
		}

		$footer = "</tbody></table>";
		$result = $header . $content . $footer . $pagination;

		echo json_encode($result);
	}

	public function withdrawal_exec($data) {
		$response_array = array();

		$agent_id = $data['agent_id'];
		$data['holder_name'] = ucwords(strtolower($data['holder_name']));
		$amount = $data['amount'];
		$password = hash::create("sha256", $data['password'], HASH_PASSWORD_KEY);

		$userdata = $this->db->select("user_accounts", "*", "agent_id = '$agent_id'", "fetch");
		$userPassword = $userdata['password'];

		$userAccType = $userdata['acc_type'];

		$availableComm = user::getAvailableComm($agent_id);

		$checkWithdrawProcess = $this->db->count("user_withdrawal", "agent_id = '$agent_id' AND (status = '0' OR status = '1')");

		if ($password != $userPassword) {   //        CHECK PASSWORD
			$response_array['r'] = "false";
			$response_array['msg'] = "<div>Incorrect account <b>Password</b>. Please make sure you enter the correct password.</div>";
		} elseif ($userAccType == "pb") {   //        CHECK ACCOUNT TYPE
			$response_array['r'] = "false";
			$response_array['msg'] = "<div>Sorry! Your account is <b>Publisher (30 days trial) account</b>. Please upgrade your account if you want to enjoy the commission.</div>";
		} elseif ($amount < 100) {   //        CHECK MINIMUM PAYOUT
			$response_array['r'] = "false";
			$response_array['msg'] = "<div>Invalid withdrawal <b>Amount</b>. Minimum withdrawal amount : RM100</div>";
		} elseif ($availableComm < $amount) {   //        CHECK AVAILABLE PAYOUT
			$response_array['r'] = "false";
			$response_array['msg'] = "<div>Insuficient <b>Payout Balance</b>. Available payout : RM" . number_format($availableComm) . "</div>";
		} elseif ($checkWithdrawProcess > 0) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div>Sorry! Looks like you have withdrawal request that still pending or in process. Please wait until your last withdrawal request complete.</div>";
		} else {

			unset($data['password']);
			$data['amount'] = $amount - 5;
			$data['remarks'] = "RM5 is deduct for bank process and admin fee. (return if status failed.)";

			$this->db->insert("user_withdrawal", $data);

			$response_array['r'] = "true";
			$response_array['msg'] = BASE_PATH . "comm/withdrawal";
		}

		return $response_array;
	}

	public function cancelWithdraw($id) {
		$response_array = array();

		$status = $this->db->select("user_withdrawal", "status,date_request", "id = '$id'", "fetch");
		if ($status['status'] == 0) {
			$this->db->delete("user_withdrawal", "id = '$id'");
			$response_array['r'] = "true";
			$response_array['msg'] = "Successfuly delete withdrawal request [" . date("d M Y h:i A", strtotime($status['date_request'])) . "].";
		} else {
			$response_array['r'] = "false";
			$response_array['msg'] = "Sorry! There are some technical issue while deleting your withdrawal request. Please contact 1STG Support Team.";
		}

		echo json_encode($response_array);
	}

}
