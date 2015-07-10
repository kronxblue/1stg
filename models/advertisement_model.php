<?php

class advertisement_model extends model {

	function __construct() {
		parent::__construct();
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

	public function advertisementList() {
		$self_address = BASE_PATH . "advertisement";

		if (!isset($_REQUEST['s'])) {
			$_GET['s'] = NULL;
		}
		if (!isset($_REQUEST['p'])) {
			$_GET['p'] = 1;
		}


		$header = "<table class='table table-bordered table-condensed'><thead><tr><th class='text-center' width='50px'>#</th><th class='text-center' width='150px'>Ads ID</th><th class='text-center' width='150px'>Ads Pin</th><th class='text-center' >Supplier Name</th><th class='text-center' >Ads Name</th><th class='text-center' width='150px'>Document Date</th><th class='text-center' width='150px'>Receive Date</th><th class='text-center' width='150px'>Status</th><th class='text-center' width='150px'>Start Date</th><th class='text-center' width='150px'>Expiry Date</th><th class='text-center' width='300px'></th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$agent_id = session::get(AGENT_SESSION_NAME);

		$listExist = user::checkExist("advertisement_view", "agent_id = '$agent_id'");

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

			if (!isset($_REQUEST['sid'])) {
				$cond = "agent_id = '$agent_id'";
			} else {
				$sid = $_GET['sid'];
				$cond = "agent_id = '$agent_id' AND supplier_id = '$sid'";
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
					$supplier_name = "<a href='" . BASE_PATH . "supplier?s=" . $supplier_data['comp_name'] . "'>" . $supplier_data['comp_name'] . "</a>";

					$ads_name = $value['ads_name'];

					$doc_date =($value['date_doc'] != NULL) ? date("d M Y", strtotime($value['date_doc'])) : "N/A";
					$receive_date = ($value['date_receive'] != NULL) ? date("d M Y", strtotime($value['date_receive'])) : "N/A";

					$ads_status = $value['ads_status'];

					$date_start = ($value['date_start'] != NULL) ? date("d M Y", strtotime($value['date_start'])) : "N/A";
					$date_end = ($value['date_end'] != NULL) ? date("d M Y", strtotime($value['date_end'])) : "N/A";

					$action = "<button type='button' class='btn btn-primary btn-xs btn-details-toggles' data-toggle='modal' data-target='#detailsModal' data-adsid='$ads_id' data-url='$self_address/ajaxAdsDetails'><i class='fa fa-file-text fa-fw'></i> Details</button>";

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

	public function addNew_exec($data) {
		$response_array = array();

		$data['agent_id'] = session::get(AGENT_SESSION_NAME);
		$data['comp_name'] = ucwords($data['comp_name']);
		$data['comp_reg_no'] = ucfirst($data['comp_reg_no']);
		$data['comp_address'] = ucwords($data['comp_address']);

		if ($data['comp_state'] == "oth") {
			$data['comp_state'] = $data['state_other'];
		}
		unset($data['state_other']);

		$data['website'] = strtolower($data['website']);
		$data['tag'] = strtolower($data['tag']);
		$data['p_fullname'] = ucwords(strtolower($data['p_fullname']));
		$data['p_pos'] = ucwords(strtolower($data['p_pos']));

		$agent_id = $data['agent_id'];

		for ($x = 1; $x <= 5; $x++) {
			$userID = $this->db->select("user_accounts", "sponsor_id", "agent_id = $agent_id", "fetch");

			$agent_id = $userID['sponsor_id'];
			$data['lv' . $x] = $agent_id;
		}

//		Generate Confirmation Code
		$supplier = new user;
		$data['confcode'] = $supplier->generateActivationCode($data['comp_email']);

		foreach ($data as $key => $value) {
			if ($value == "") {
				$data[$key] = NULL;
			}
		}

		$insert = $this->db->insert("supplier", $data);

		if (!$insert) {
			$response_array['r'] = "false";
			$response_array['msg'] = "Oopps! Looks like there is some technical error while process your supplier registration. Please re-submit the form or refresh your browser.";
		} else {

			//            Generate Email BODY

			$link = BASE_PATH . 'supp/verify?a=' . $data['confcode'] . '&s=' . $data['username'];

			$html = file_get_contents(BASE_PATH . 'email_template/supplier_activation');
			$html = htmlspecialchars($html);

			$html = str_replace('[USERNAME]', $data['username'], $html);
			$html = str_replace('[ACTIVATION_CODE]', $link, $html);

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
			$mailer->FromName = WYW_SUPPORT_NAME;
			$mailer->AddAddress($data['comp_email']);
			$mailer->IsHTML(true);

			$mailer->Subject = "Email verification to " . $data['comp_email'] . " for Free Supplier registration.";
			$mailer->Body = $body;

			$send = $mailer->Send();

			if (!$send) {
				$response_array['r'] = "false";
				$response_array['msg'] = "Mailer Error: " . $mailer->ErrorInfo;
			} else {
				$response_array['r'] = "true";
				$response_array['msg'] = BASE_PATH . "supplier?r=success&t=addnew&a=" . $data['comp_name'];
			}
		}


		return $response_array;
	}

	public function ajaxAdsDetails($ads_id) {

		$ads_data = user::getAdsData("ads_id", "$ads_id");

		$data = array();
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
