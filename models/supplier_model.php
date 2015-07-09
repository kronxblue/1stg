<?php

class supplier_model extends model {

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

	public function addNew_exec($data) {
		$response_array = array();

		$data['agent_id'] = session::get(AGENT_SESSION_NAME);
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
			$response_array['msg'] = BASE_PATH . "supplier?r=success&t=addnew&a=" . $data['comp_name'];
		}


		return $response_array;
	}

	public function ajaxSupplierList() {

		$self_address = BASE_PATH . "supplier";

		$header = "<table class='table table-bordered table-condensed'><thead><tr><th class='text-center' width='50px'>#</th><th class='text-center' width='100px'>Type</th><th class='text-center' width='250px'>Name</th><th class='text-center' width='150px'>Category</th><th class='text-center' width='150px'>State, Country</th><th class='text-center' width='400px'>Business Desc</th><th class='text-center' width='150px'>Advertisement</th><th class='text-center' width='150px'>Status</th><th class='text-center' width='250px'>Action</th></tr></thead><tbody>";
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

					$descLenght = strlen($value['desc']);
					if ($descLenght > 50) {
						$desc = "<span class='desc'>" . substr($value['desc'], 0, 50) . "... </span>";
						$desc .= "<a class='btn btn-xs btn-info btn-more-desc' href='$self_address/ajaxSupplierDesc' data-view='0' data-supplier='$supplier_id' title='Read more'><i class='fa fa-angle-down fa-fw'></i></a>";
					} else {
						$desc = "<span class='desc'>" . $value['desc'] . "</span>";
					}

					$count_ads = $this->db->count("advertisement_view", "supplier_id = $supplier_id");
					$ads_count = "<a class='btn btn-xs btn-link' href='" . BASE_PATH . "advertisement?sid=$supplier_id' title='View all advertisement from this supplier.'>$count_ads</a>";
					$total_ads = $ads_count;

					$status = ($value['status'] == 0) ? "<span class='text-danger'>Waiting to verify</span>" : "<span class='text-success'>Verified</span>";

					$action = "<div class='col-xs-12'><a class='btn btn-xs btn-info' href='$self_address/details?sid=$supplier_id' title='View supplier details.'><i class='fa fa-file-text fa-fw'></i> Details</a></div>";

					$content .= "<tr class='text-center $color'>";

					$content .= "<td>$x</td>";
					$content .= "<td>$type</td>";
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

	public function ajaxSupplierDesc($data) {
		$view_stat = $data['view'];
		$supplier_id = $data['supplier_id'];

		$supplier_desc = $this->db->select("user_suppliers", "`desc`", "supplier_id = $supplier_id", "fetch");

		if ($view_stat == "0") {
			$desc = $supplier_desc['desc'] . " ";
		} else {
			$desc = substr($supplier_desc['desc'], 0, 50) . "... ";
		}

		return $desc;
	}

	public function details($supplier_id) {
		
	}

}
