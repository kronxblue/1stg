<?php

class supp_model extends model {

	function __construct() {
		parent::__construct();
	}

	public function getReferral() {

		$chkCookie = cookie::exists(COOKIE_SPONSOR_NAME);

		if ($chkCookie) {
			$referral = cookie::get(COOKIE_SPONSOR_NAME);
		} else {
			$referral = NULL;
		}

		return $referral;
	}

	public function register_exec($data) {
		$response_array = array();

//        Clean data
		foreach ($data as $key => $value) {
			$data[$key] = ($data[$key] == "") ? NULL : $value;
		}

		$data['comp_name'] = ucwords($data['comp_name']);
		$data['comp_reg_no'] = strtoupper($data['comp_reg_no']);
		$data['comp_address'] = ucwords($data['comp_address']);
		if ($data['website'] != NULL) {
			$checkURL = strstr($data['website'], "http://");

			$data['website'] = ($checkURL) ? $data['website'] : "http://" . $data['website'];
		}
		$data['desc'] = ucfirst($data['desc']);
		$data['p_fullname'] = ucwords($data['p_fullname']);
		$data['p_pos'] = strtoupper($data['p_pos']);

//        Validate additional field
//        Check Password
		$password = $data['pass'];
		$cpassword = $data['confpass'];
		$chkPassword = ($password == $cpassword) ? TRUE : FALSE;

//        Check Username
		$username = $data['username'];

		$usernameExist = $this->db->count("supplier", "username = '$username'");
		$chkUsername = ($usernameExist == 0) ? TRUE : FALSE;

//        Check Referral
		$agent_id = $data['agent_id'];
		$checkID = $this->db->count("user_accounts", "agent_id = '$agent_id'");

		$error = NULL;

		if (!$chkPassword) {
			$error = "<strong>Password</strong> and <strong>Confirm Password</strong> not match.";
		} elseif (!$chkUsername) {
			$error = "<strong>Username</strong> already exist.";
		} elseif ($checkID == 0) {
			$error = "<strong>Referral ID</strong> does not valid.";
		}

		if (!empty($error)) {
			$response_array['r'] = "false";
			$response_array['msg'] = $error;
		} else {

//            Generate Hash Password
			$data['pass'] = hash::create("sha256", $data['pass'], HASH_PASSWORD_KEY);

//            Generate Confirmation Code
			$supplier = new user;
			$data['confcode'] = $supplier->generateActivationCode($data['comp_email']);

			$insert = $this->db->insert("supplier", $data);

			if ($insert) {
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
					$response_array['msg'] = BASE_PATH . "supp/success/" . $data['username'];
				}
			} else {
				$response_array['r'] = "false";
				$response_array['msg'] = "Oopps! Looks like there are some technical error while process your registration. Please re-submit the form or refresh your browser. Then refill the form.";
			}
		}
		return $response_array;
	}

	function resend_activation($data = FALSE) {

		if (!$data) {
			return FALSE;
		} else {
			$link = BASE_PATH . 'supp/verify?a=' . $data['confcode'] . '&s=' . $data['username'];

//            Generate Email BODY

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

			return $mailer->Send();
		}
	}

	function verify($a, $s) {
		$userDate = user::getSupplierData("username", "$s");
		$confcode = $userDate['confcode'];
		
		return ($confcode == $a) ? TRUE : FALSE;
	}
	
	function sendWelcomeEmail($s) {
		
	}

}
