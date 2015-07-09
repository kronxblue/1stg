<?php

class join_model extends model {

	function __construct() {
		parent::__construct();
		session::init();
	}

	public function getReferer() {
		$chkCookie = cookie::exists(COOKIE_SPONSOR_NAME);

		if ($chkCookie) {
			$refID = cookie::get(COOKIE_SPONSOR_NAME);
			$validRef = $this->db->count("user_accounts", "agent_id = '$refID'");
			if ($validRef != 0) {
				$return = $refID;
			} else {
				cookie::delete(COOKIE_SPONSOR_NAME);
				$return = FALSE;
			}

			return cookie::get(COOKIE_SPONSOR_NAME);
		} else {
			$return = FALSE;
		}

		return $return;
	}

	public function getRefererData($referer) {
		if ($referer != FALSE) {
			$data = $this->db->select("user_accounts", "*", "agent_id = '$referer'", "fetch");
			return $data;
		}
	}

	public function chkUsername($data) {

		if (strlen($data) < 3) {
			return 'min_error';
		} else {
			return user::checkExist("user_accounts", "username = '$data'");
		}
	}

	public function join_exec($data) {

		$response_array = array();

		$agent = new user;

		$data['fullname'] = strtoupper($data['fullname']);
		$data['agent_id'] = $agent->generateID();
		$data['tmp_password'] = strtoupper(hash::create('crc32', uniqid(), HASH_PASSWORD_KEY));
		$data['activate_code'] = $agent->generateActivationCode($data['email']);

		$acc_type = $data['acc_type'];

		switch ($acc_type) {
			case "pb":
				$ads_pin_limit = "na";
				$available_pin = 0;
				break;
			case "aa":
				$ads_pin_limit = "na";
				$available_pin = 0;
				break;
			case "ed":
				$ads_pin_limit = 10;
				$available_pin = 10;
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

		$checkEmail = $agent->checkEmail($data['email']);
		$checkCEmail = $agent->checkCdata($data['email'], $data['cemail']);
		$checkUsername = $data['chkusername'];

		$sponsor_id = $data['sponsor_id'];
		$checkSponsodID = user::checkExist("user_accounts", "agent_id = '$sponsor_id'");

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
		} elseif (!$checkSponsodID) {
			$response_array['r'] = "false";
			$response_array['msg'] = "<div><b>Refferal ID</b> not valid! Please ask Refferal ID from the person who introduce you to 1STG Programs. If you don't have any refferal, you can directly <a href='" . BASE_PATH . "contact'>contact us</a> for an assistance.<div>";
		} else {

			unset($data['cemail']);
			unset($data['chkusername']);

			$link = BASE_PATH . 'join/verify?a=' . $data['activate_code'] . '&s=' . $data['username'];
			$agent_id = $data['sponsor_id'];
			$upline_id = $agent->generateUpline($agent_id);

			$newUplineData = $this->newUplineData($upline_id);
			foreach ($newUplineData as $key => $value) {
				$data[$key] = $value;
			}

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
				$response_array['msg'] = BASE_PATH . "join/success/" . $data['agent_id'];
			}
		}

		return $response_array;
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

	function resend_activation($data = FALSE) {

		if (!$data) {
			return FALSE;
		} else {
			$link = BASE_PATH . 'join/verify?a=' . $data['activate_code'] . '&s=' . $data['username'];

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

			return $mailer->Send();
		}
	}

	function verify($salt, $code, $data) {

		if ($salt != $code) {
			return FALSE;
		} else {

//            Email temporary password

			$sponsorData = user::getUserData('agent_id', $data['sponsor_id']);

			$sponsor_fullname = $sponsorData['fullname'];
			if ($sponsorData['wyw_email'] != NULL) {
				$sponsor_email = $sponsorData['wyw_email'] . '@whatyouwant.my';
			} else {
				$sponsor_email = $sponsorData['email'];
			}
			$sponsor_mobile = $sponsorData['mobile'];

			$company_name = $this->db->select("site_settings", "*", "name = 'company_name'", "fetch");
			$company_name = $company_name['param'];

			$agent_id = $data['agent_id'];
			$acc_type_code = $data['acc_type'];
			$acc_type_detail = user::getAccType($acc_type_code);
			$acc_type = $acc_type_detail['label'];
			$acc_price = number_format($acc_type_detail['price']);
			$agent_fullname = ucwords(strtolower($data['fullname']));
			$agent_username = $data['username'];
			$agent_tmp_password = $data['tmp_password'];

			$support_email = SUPPORT_EMAIL;

//            Generate email body

			$html = file_get_contents(BASE_PATH . 'email_template/activation_success');
			$html = htmlspecialchars($html);

			$html = str_replace('[AGENT_ID]', $agent_id, $html);
			$html = str_replace('[ACC_TYPE]', $acc_type, $html);
			$html = str_replace('[ACC_PRICE]', $acc_price, $html);
			$html = str_replace('[FULLNAME]', $agent_fullname, $html);
			$html = str_replace('[USERNAME]', $agent_username, $html);
			$html = str_replace('[TMP_PASSWORD]', $agent_tmp_password, $html);
			$html = str_replace('[SPONSOR_FULLNAME]', $sponsor_fullname, $html);
			$html = str_replace('[SPONSOR_EMAIL]', $sponsor_email, $html);
			$html = str_replace('[SPONSOR_MOBILE]', $sponsor_mobile, $html);
			$html = str_replace('[SUPPORT_EMAIL]', $support_email, $html);
			$html = str_replace('[COMPANY_NAME]', $company_name, $html);

			$html = html_entity_decode($html);

			$body = $html;

//            Send Email
			$mailer = new mailer();

			$mailer->IsSMTP(); // set mailer to use SMTP
			$mailer->Port = EMAIL_PORT;
			$mailer->Host = EMAIL_HOST;      // specify main and backup server
			$mailer->SMTPAuth = true; // turn on SMTP authentication
			$mailer->Username = NOREPLY_EMAIL;      // SMTP username
			$mailer->Password = NOREPLY_PASS;       // SMTP password
			$mailer->From = NOREPLY_EMAIL;
			$mailer->FromName = SUPPORT_NAME;
			$mailer->AddAddress($data['email']);
			$mailer->IsHTML(true);

			$mailer->Subject = "Welcome to 1STG Entrepreneurship Program.";
			$mailer->Body = $body;

			if (!$mailer->Send()) {
				return FALSE;
			} else {

//                clear activation code and change activation status in DB

				$updateData = array();

				$updateData['activate_code'] = NULL;
				$updateData['activate'] = 1;

				$id = $data['agent_id'];

				$this->db->update("user_accounts", $updateData, "agent_id = '$id'");

				return TRUE;
			}
		}
	}

	function resend_details($email = FALSE) {

		if (!$email) {
			return FALSE;
		} else {

//            Email temporary password

			$data = user::getUserData('email', $email);
			$sponsorData = user::getUserData('agent_id', $data['sponsor_id']);

			$sponsor_fullname = $sponsorData['fullname'];
			if ($sponsorData['wyw_email'] != NULL) {
				$sponsor_email = $sponsorData['wyw_email'] . '@whatyouwant.my1';
			} else {
				$sponsor_email = $sponsorData['email'];
			}
			$sponsor_mobile = $sponsorData['mobile'];

			$company_name = $this->db->select("site_settings", "*", "name = 'company_name'", "fetch");
			$company_name = $company_name['param'];

			$agent_id = $data['agent_id'];
			$acc_type_code = $data['acc_type'];
			$acc_type_detail = user::getAccType($acc_type_code);
			$acc_type = $acc_type_detail['label'];
			$acc_price = number_format($acc_type_detail['price']);
			$agent_fullname = ucwords(strtolower($data['fullname']));
			$agent_username = $data['username'];
			$agent_tmp_password = $data['tmp_password'];

			$support_email = SUPPORT_EMAIL;

//            Generate email body

			$html = file_get_contents(BASE_PATH . 'email_template/activation_success');
			$html = htmlspecialchars($html);

			$html = str_replace('[AGENT_ID]', $agent_id, $html);
			$html = str_replace('[ACC_TYPE]', $acc_type, $html);
			$html = str_replace('[ACC_PRICE]', $acc_price, $html);
			$html = str_replace('[FULLNAME]', $agent_fullname, $html);
			$html = str_replace('[USERNAME]', $agent_username, $html);
			$html = str_replace('[TMP_PASSWORD]', $agent_tmp_password, $html);
			$html = str_replace('[SPONSOR_FULLNAME]', $sponsor_fullname, $html);
			$html = str_replace('[SPONSOR_EMAIL]', $sponsor_email, $html);
			$html = str_replace('[SPONSOR_MOBILE]', $sponsor_mobile, $html);
			$html = str_replace('[SUPPORT_EMAIL]', $support_email, $html);
			$html = str_replace('[COMPANY_NAME]', $company_name, $html);

			$html = html_entity_decode($html);

			$body = $html;

//            Send Email
			$mailer = new mailer();

			$mailer->IsSMTP(); // set mailer to use SMTP
			$mailer->Port = EMAIL_PORT;
			$mailer->Host = EMAIL_HOST;      // specify main and backup server
			$mailer->SMTPAuth = true; // turn on SMTP authentication
			$mailer->Username = NOREPLY_EMAIL;      // SMTP username
			$mailer->Password = NOREPLY_PASS;       // SMTP password
			$mailer->From = NOREPLY_EMAIL;
			$mailer->FromName = SUPPORT_NAME;
			$mailer->AddAddress($data['email']);
			$mailer->IsHTML(true);

			$mailer->Subject = "Welcome to 1STG Entrepreneurship Program.";
			$mailer->Body = $body;

			return $mailer->Send();
		}
	}

}
