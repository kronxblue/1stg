<?php

class mynetwork_model extends model {

	function __construct() {
		parent::__construct();
		session::init();
	}

	public function monthList() {
		$monthList = array();
		for ($i = 0; $i < 12; $i++) {
			$monthList[$i] = date("M Y", strtotime("-$i months"));
		}
		krsort($monthList);

		return $monthList;
	}

	public function countDownline($agent_id, $accType, $monthList) {
		$dowlineListArr = array();

		foreach ($monthList as $value) {
			$join_date = date("Y-m", strtotime($value));
			$dowlineListArr[] = $this->db->count("user_accounts", "sponsor_id = '$agent_id' AND acc_type = '$accType' AND dt_join LIKE '%$join_date%'");
		}

		return $dowlineListArr;
	}

	public function downlineList($userdata) {

		$self_address = BASE_PATH . "mynetwork";

		$header = "<table class='table table-bordered'><thead><tr><th class='text-center' width='50px'>#</th><th class='text-center' width='250px'>Fullname</th><th class='text-center' width='200px'>Email</th><th class='text-center' width='200px'>Mobile No.</th><th class='text-center' width='150px'>Username</th><th class='text-center' width='150px'>Account Type</th><th class='text-center' width='150px'>Status</th><th class='text-center' width='150px'>Action</th></tr></thead><tbody>";
		$content = "";
		$pagination = "";

		$agent_id = $userdata['agent_id'];

		$downlineExist = user::checkExist("user_accounts", "sponsor_id = '$agent_id'");

		if (!$downlineExist) {
			$content .= "<tr><td class ='text-center' colspan='8'>No downline record.</td></tr>";
		} else {

			if (isset($_REQUEST['s'])) {

				if ($_GET['s'] != "") {
					$searchItm = $_GET['s'];
					$searchSQL = " AND (fullname LIKE '%$searchItm%' OR username LIKE '%$searchItm%')";
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
				$downlineList_full = $this->db->select("user_accounts", "*", "sponsor_id = '$agent_id' ORDER BY id DESC");
			} else {
				$downlineList_full = $this->db->select("user_accounts", "*", "sponsor_id = '$agent_id' $searchSQL ORDER BY id DESC");
			}

			$total_row = count($downlineList_full);


			$total_pages = ceil($total_row / $max_result);

			$pagination .= "<ul class='pagination pagination-sm'>";

			if ($current_page > 1) {
				$pagination .= "<li><a href='$self_address?p=$prev_page$get_search'><span class='fa fa-angle-double-left fa-fw'></span> Back</a></li>";
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
					$pagination .= "<li><a href='$self_address?p=$i$get_search'>$i</a></li>";
				}
			}

			if ($current_page < $total_pages - 5) {
				$pagination .= "<li class='disabled'><a href='#'>..</a></li>";
				$pagination .= "<li><a href='#'>$total_pages</a></li>";
			}

			if ($current_page < $total_pages) {
				$pagination .= "<li><a href='$self_address?p=$next_page$get_search'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			} else {
				$pagination .= "<li class='disabled'><a href='#'>Next <span class='fa fa-angle-double-right fa-fw'></span></a></li>";
			}

			$pagination .= "</ul>";


			if ($searchItm == NULL) {
				$downlineList_limit = $this->db->select("user_accounts", "*", "sponsor_id = '$agent_id' LIMIT $from,$max_result");
			} else {
				$downlineList_limit = $this->db->select("user_accounts", "*", "sponsor_id = '$agent_id' $searchSQL LIMIT $from,$max_result");
			}


			if ($total_row == 0) {
				$content .= "<tr><td class ='text-center' colspan='8'>No downline record.</td></tr>";
				$pagination = NULL;
			} else {

				if ($total_row <= $max_result) {
					$pagination = NULL;
				}

				$x = $from + 1;

				foreach ($downlineList_limit as $value) {

					$user_id = $value['agent_id'];

//                GET USER IMAGE
					$userImageExist = user::checkExist("user_images", "agent_id = '$user_id' AND profile = '1'");

					if (!$userImageExist) {
						$image = "user-default.png";
					} else {
						$image = $this->db->select("user_images", "filename", "agent_id = '$user_id' AND profile = '1'", "fetch");
						$image = "users/" . $image['filename'];
					}


//                GET ACCOUNT STATUS
					$emailVerify = $value['activate'];

					if (!$emailVerify) {
						$labelStatus = "label-danger";
						$abbr = "Email and payment verification not complete.";
						$status = "Not Activate";
					} else {
						$paymentVerify = $value['payment'];

						switch ($paymentVerify) {
							case '-1':
								$labelStatus = "label-danger";
								$abbr = "Payment not complete.";
								$status = "Pending";
								break;
							case 0:
								$labelStatus = "label-danger";
								$abbr = "Waiting for payment.";
								$status = "Pending";
								break;
							case 1:
								$labelStatus = "label-warning";
								$abbr = "Payment have been issue and still in verification process.";
								$status = "Pending";
								break;

							default:
								$labelStatus = "label-success";
								$abbr = "Email and payment verification complete.";
								$status = "Active";
								break;
						}
					}


//                CONSTRUCT CONTENT
					$fullname = ucwords(strtolower($value['fullname']));
					$userImage = IMAGES_PATH . $image;
					$email = $value['email'];
					$mobile = $value['mobile'];
					$username = $value['username'];
					$accType = user::getAccType($value['acc_type']);
					$accType = $accType['label'];
					$status = "<abbr title='$abbr'><span class='label $labelStatus'>$status</span></abbr>";
					$message = BASE_PATH . "message/compose?to=$username";


					$content .= "<tr>";

					$content .= "<td class='text-center'>$x</td>";
					$content .= "<td><a class='userImage' href='#' data-image='$userImage'>$fullname</a></td>";
					$content .= "<td class='text-center'>$email</td>";
					$content .= "<td class='text-center'>$mobile</td>";
					$content .= "<td class='text-center'>$username</td>";
					$content .= "<td class='text-center'>$accType</td>";
					$content .= "<td class='text-center'>$status</td>";
					$content .= "<td><div class='col-xs-12 text-center'><a class='unavailable-link' href='$message' title='Message $username'><i class='fa fa-comment fa-fw'></i> Message</a></div></td>";



					$content .= "</tr>";
					$x++;
				}
			}
		}

		$footer = "</tbody></table>";

		$result = $header . $content . $footer . $pagination;

		echo json_encode($result);
	}

	public function topUser($agent_id) {

		$userData = $this->db->select("user_accounts", "sponsor_id, agent_id, username", "agent_id = '$agent_id'", "fetch");

		$imageExist = user::checkExist("user_images", "agent_id = '$agent_id' AND profile = '1'");

		if (!$imageExist) {
			$userImage = IMAGES_PATH . "user-default.png";
		} else {
			$img = user::getUserImages($agent_id, TRUE);
			$userImage = IMAGES_PATH . "users/" . $img['filename'];
		}



		$userData['image'] = $userImage;

		return $userData;
	}

	public function midUser($agent_id) {

		$totalUser = $this->db->count("user_accounts", "lv1 = '$agent_id'");

		if ($totalUser == 0) {
			$userData = array();
			for ($i = 0; $i < 5; $i++) {
				$userData[$i] = NULL;
			}
		} else {
			$userData = $this->db->select("user_accounts", "agent_id, username", "lv1 = '$agent_id'");

			foreach ($userData as $key => $value) {
				$user_id = $value['agent_id'];
				$imageExist = user::checkExist("user_images", "agent_id = '$user_id' AND profile = '1'");

				if (!$imageExist) {
					$userImage = IMAGES_PATH . "user-default.png";
				} else {
					$img = user::getUserImages($user_id, TRUE);
					$userImage = IMAGES_PATH . "users/" . $img['filename'];
				}

				$userData[$key]['image'] = $userImage;
			}

			$count_userData = count($userData);

			for ($x = $count_userData; $x < 5; $x++) {
				$userData[] = NULL;
			}
		}

		return $userData;
	}

	public function bottomUser($usersData) {

		$users_ID = array();

		foreach ($usersData as $key => $value) {
			if ($value != NULL) {
				$users_ID[$key] = $value['agent_id'];
			} else {
				$users_ID[$key] = NULL;
			}
		}

		$usersData = array();

		foreach ($users_ID as $key => $value) {

			if ($value != NULL) {

				$agent_id = $value;

				$userSingleData = $this->db->select("user_accounts", "agent_id, username", "lv1 = '$agent_id'");

				foreach ($userSingleData as $key2 => $value2) {

					$user_id = $value2['agent_id'];

					$imageExist = user::checkExist("user_images", "agent_id = '$user_id' AND profile = '1'");

					if (!$imageExist) {
						$userImage = IMAGES_PATH . "user-default.png";
					} else {
						$img = user::getUserImages($user_id, TRUE);
						$userImage = IMAGES_PATH . "users/" . $img['filename'];
					}

					$userSingleData[$key2]['image'] = $userImage;
				}

				$usersData[$key] = $userSingleData;

				$countUser = count($userSingleData);

				for ($i = $countUser; $i < 5; $i++) {
					$usersData[$key][$i] = NULL;
				}
			} else {

				for ($i = 0; $i < 5; $i++) {
					$usersData[$key][$i] = NULL;
				}
			}
		}

		return $usersData;
	}

	public function newUplineData($agent_id) {
		$lvlData = $this->db->select("user_accounts", "lv1,lv2,lv3,lv4,lv5,lv6,lv7,lv8,lv9,lv10", "agent_id = '$agent_id'", "fetch");
		$data['lv1'] = $agent_id;
		$i = 2;
		foreach ($lvlData as $key => $value) {
			if ($value != NULL) {
				$data['lv' . $i] = $value;
			} else {
				$data['lv' . $i] = NULL;
			}
			$i++;
		}
		unset($data['lv11']);

		return $data;
	}

	public function getSponsorId($agent_id) {

		$owner_ID = session::get(AGENT_SESSION_NAME);
		$mydata = $this->db->select("user_accounts", "agent_id,username", "agent_id = '$owner_ID'", "fetch");


		$cond = "(agent_id LIKE '%$agent_id%' OR username LIKE '%$agent_id%') AND (lv1 = '$owner_ID' OR lv2 = '$owner_ID' OR lv3 = '$owner_ID' OR lv4 = '$owner_ID' OR lv5 = '$owner_ID' OR lv6 = '$owner_ID' OR lv7 = '$owner_ID' OR lv8 = '$owner_ID' OR lv9 = '$owner_ID' OR lv10 = '$owner_ID') LIMIT 0,10";
		$usersData = $this->db->select("user_accounts", "agent_id, username", $cond);

		if ((strpos($mydata['agent_id'], $agent_id) !== FALSE) or ( strpos($mydata['username'], $agent_id) !== FALSE)) {
			$usersData[] = $mydata;
		}

		foreach ($usersData as $key => $value) {
			$userID = $value['agent_id'];
			$imageExist = user::checkExist("user_images", "agent_id = '$userID' and profile = '1'");
			if ($imageExist) {
				$image = user::getUserImages($userID, TRUE);
				$imagePath = IMAGES_PATH . "users/" . $image['filename'];
			} else {
				$imagePath = IMAGES_PATH . "user-default.png";
			}
			$usersData[$key]['image'] = $imagePath;
		}

		return $usersData;
	}

	public function addagent_exec($data) {
		$response_array = array();

		foreach ($data as $key => $value) {
			if ($value == "") {
				$data[$key] = NULL;
			}
		}

		$agent = new user;

		$data['fullname'] = strtoupper($data['fullname']);
		$data['agent_id'] = $agent->generateID();
		$data['tmp_password'] = strtoupper(hash::create('crc32', uniqid(), HASH_PASSWORD_KEY));
		$data['activate_code'] = $agent->generateActivationCode($data['email']);

		$acc_type = $data['acc_type'];

		switch ($acc_type) {
			case "aa":
				$ads_pin_limit = 1;
				$available_pin = 1;
				break;
			case "ad":
				$ads_pin_limit = 15;
				$available_pin = 15;
				break;
			case "ed":
				$ads_pin_limit = 20;
				$available_pin = 20;
				break;
			case "ep":
				$ads_pin_limit = 40;
				$available_pin = 40;
				break;
			default:
				$ads_pin_limit = "unlimited";
				$available_pin = 40;
				break;
		}

		$data['ads_pin_limit'] = $ads_pin_limit;
		$data['available_pin'] = $available_pin;

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

		$checkEmail = $agent->checkEmail($data['email']);
		$checkCEmail = $agent->checkCdata($data['email'], $data['cemail']);
		$checkUsername = $data['chkusername'];

		$validUplineSponsor = FALSE;

		$sponsorId = $data['sponsor_id'];
		$uplineId = $data['lv1'];


		if ($sponsorId != $uplineId) {
			$upline_data = $this->db->select("user_accounts", "lv1,lv2,lv3,lv4,lv5,lv6,lv7,lv8,lv9,lv10", "agent_id = '$uplineId'", "fetch");
			foreach ($upline_data as $value) {
				if ($value == $sponsorId) {
					$validUplineSponsor = TRUE;
				}
			}
		} else {
			$validUplineSponsor = TRUE;
		}

//GENERATE ADS PIN
		if ($acc_type == "aa") {
			$ads_pin = "1000000";
		} else {
			$ads_pin = $agent->getRegPin();
		}
		
		$data['ads_pin'] = $ads_pin;

		if (!$checkCEmail) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Confirm Email</b> not match!</div>";
		} elseif (!$checkEmail) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Email</b> already exist!</div>";
		} elseif ($checkUsername == 0) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div>Please <b>Check Username</b> availability!<div>";
		} elseif ($checkUsername == '-1') {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Username</b> not available! Please choose another username.<div>";
		} elseif (!$validUplineSponsor) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Sponsor ID: $sponsorId</b> not related with <b>Upline ID: $uplineId</b>. Please make sure <b>Upline ID</b> is under correct <b>Sponsor ID</b> network.<div>";
		} else {

			$link = BASE_PATH . 'join/verify?a=' . $data['activate_code'] . '&s=' . $data['username'];
			
			unset($data['cemail']);
			unset($data['chkusername']);

//            Insert into Database
			$this->db->insert("user_accounts", $data);

//            Generate Email BODY

			$html = file_get_contents(BASE_PATH . 'email_template/activation');
			$html = htmlspecialchars($html);

			$html = str_replace('[USERNAME]', ucfirst($data['username']), $html);
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
			$mailer->FromName = SUPPORT_NAME;
			$mailer->AddAddress($data['email']);
			$mailer->IsHTML(true);

			$mailer->Subject = "Email verification to " . $data['email'];
			$mailer->Body = $body;
			if (!$mailer->Send()) {
				$response_array['r'] = "false";
				$response_array['msg'] = "Mailer Error: " . $mailer->ErrorInfo;
			} else {
				$response_array['r'] = "true";
				$response_array['msg'] = BASE_PATH . "mynetwork/addagent_success/" . $data['agent_id'];
			}
		}

		return $response_array;
	}

}
