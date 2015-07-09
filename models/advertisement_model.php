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
					$searchSQL = " AND (ads_name LIKE '%$searchItm%') OR (supplier_id LIKE '%$searchItm%')";
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
				$supplierList_full = $this->db->select("advertisement_view", "*", "agent_id = '$agent_id' ORDER BY id DESC");
			} else {
				$supplierList_full = $this->db->select("advertisement_view", "*", "agent_id = '$agent_id' $searchSQL ORDER BY id DESC");
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
				$supplierList_limit = $this->db->select("user_suppliers", "*", "agent_id = '$agent_id' ORDER BY id DESC LIMIT $from,$max_result");
			} else {
				$supplierList_limit = $this->db->select("user_suppliers", "*", "agent_id = '$agent_id' $searchSQL ORDER BY id DESC LIMIT $from,$max_result");
			}


			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='8'>No supplier record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($supplierList_limit as $value) {


//                CONSTRUCT CONTENT
					$supplier_id = $value['supplier_id'];
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

					$descLenght = strlen($value['desc']);
					if ($descLenght > 50) {
						$desc = "<span class='desc'>" . substr($value['desc'], 0, 50) . "... </span>";
						$desc .= "<a class='btn btn-xs btn-info btn-more-desc' href='$self_address/ajaxSupplierDesc' data-view='0' data-supplier='$supplier_id' title='Read more'><i class='fa fa-angle-down fa-fw'></i></a>";
					} else {
						$desc = "<span class='desc'>" . $value['desc'] . "</span>";
					}

					$count_ads = $this->db->count("advertisement_view", "supplier_id = $supplier_id");
					$ads_count = "<a class='btn btn-xs btn-link' href='" . BASE_PATH . "advertisement?sid=$supplier_id' title='View all advertisement from this supplier.'>$count_ads</a>";
					$btn_newAds = "<a class='btn btn-xs btn-link unavailable-link' href='" . BASE_PATH . "advertisement/addNew?sid=$supplier_id' title='Add new advertisement for this supplier.'><i class='fa fa-plus-square fa-fw'></i> Add</a>";
					$total_ads = $ads_count . " | " . $btn_newAds;

					$status = ($value['status'] == 0) ? "<span class='text-danger'>Waiting to verify</span>" : "<span class='text-success'>Verified</span>";

					$action = "<div class='col-xs-12'><a class='btn btn-xs btn-info' href='$self_address/details?sid=$supplier_id' title='View supplier details.'><i class='fa fa-file-text fa-fw'></i> Details</a></div>";

					$content .= "<tr class='text-center'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$name</td>";
					$content .= "<td>$category</td>";
					$content .= "<td>$stateCountry</td>";
					$content .= "<td>$desc</td>";
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

	public function ajaxAdsList() {

		$self_address = BASE_PATH . "advertisement";

		$header = "<table class='table table-bordered table-condensed'><thead><tr><th class='text-center' width='50px'>#</th><th class='text-center' width='250px'>Name</th><th class='text-center' width='150px'>Category</th><th class='text-center' width='150px'>State, Country</th><th class='text-center' width='300px'>Business Desc</th><th class='text-center' width='150px'>Advertisement</th><th class='text-center' width='150px'>Status</th><th class='text-center' width='250px'>Action</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$agent_id = session::get(AGENT_SESSION_NAME);

		$listExist = user::checkExist("user_suppliers", "agent_id = '$agent_id'");

		if (!$listExist) {
			$content .= "<tr><td class ='text-center' colspan='8'>No supplier record.</td></tr>";
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
				$supplierList_full = $this->db->select("user_suppliers", "*", "agent_id = '$agent_id' ORDER BY id DESC");
			} else {
				$supplierList_full = $this->db->select("user_suppliers", "*", "agent_id = '$agent_id' $searchSQL ORDER BY id DESC");
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
				$supplierList_limit = $this->db->select("user_suppliers", "*", "agent_id = '$agent_id' ORDER BY id DESC LIMIT $from,$max_result");
			} else {
				$supplierList_limit = $this->db->select("user_suppliers", "*", "agent_id = '$agent_id' $searchSQL ORDER BY id DESC LIMIT $from,$max_result");
			}


			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='8'>No supplier record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($supplierList_limit as $value) {


//                CONSTRUCT CONTENT
					$supplier_id = $value['supplier_id'];
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

					$descLenght = strlen($value['desc']);
					if ($descLenght > 50) {
						$desc = "<span class='desc'>" . substr($value['desc'], 0, 50) . "... </span>";
						$desc .= "<a class='btn btn-xs btn-info btn-more-desc' href='$self_address/ajaxSupplierDesc' data-view='0' data-supplier='$supplier_id' title='Read more'><i class='fa fa-angle-down fa-fw'></i></a>";
					} else {
						$desc = "<span class='desc'>" . $value['desc'] . "</span>";
					}

					$count_ads = $this->db->count("advertisement_view", "supplier_id = $supplier_id");
					$ads_count = "<a class='btn btn-xs btn-link' href='" . BASE_PATH . "advertisement?sid=$supplier_id' title='View all advertisement from this supplier.'>$count_ads</a>";
					$btn_newAds = "<a class='btn btn-xs btn-link unavailable-link' href='" . BASE_PATH . "advertisement/addNew?sid=$supplier_id' title='Add new advertisement for this supplier.'><i class='fa fa-plus-square fa-fw'></i> Add</a>";
					$total_ads = $ads_count . " | " . $btn_newAds;

					$status = ($value['status'] == 0) ? "<span class='text-danger'>Waiting to verify</span>" : "<span class='text-success'>Verified</span>";

					$action = "<div class='col-xs-12'><a class='btn btn-xs btn-info' href='$self_address/details?sid=$supplier_id' title='View supplier details.'><i class='fa fa-file-text fa-fw'></i> Details</a></div>";

					$content .= "<tr class='text-center'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$name</td>";
					$content .= "<td>$category</td>";
					$content .= "<td>$stateCountry</td>";
					$content .= "<td>$desc</td>";
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

}
