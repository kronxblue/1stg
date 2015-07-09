<?php

class session {

	function __construct() {
		
	}

	public static function init() {
		@session_start();
	}

	public static function set($key, $value) {
		$_SESSION[$key] = $value;
		return $_SESSION[$key];
	}

	public static function get($key) {
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
	}

	public static function exist($key) {
		return (isset($_SESSION[$key])) ? TRUE : FALSE;
	}

	public static function delete($key) {
		if (self::exist($key)) {
			unset($_SESSION[$key]);
		}
	}

	public static function destroy() {
		session_destroy();
	}

	public static function loginAuth($from) {

		//check token remember me
		//check session

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		if (cookie::exists(TOKEN_NAME)) {
			$token = cookie::get(TOKEN_NAME);
			$checkExist = user::checkExist("users_session", "token = '$token'");

			if ($checkExist) {

				$sessionData = $db->select("users_session", "*", "token = '$token'", "fetch");

				$agent_id = $sessionData['agent_id'];
				user::login($agent_id);

				$userData = $db->select("user_accounts", "*", "agent_id = '$agent_id'", "fetch");

				if ($from == 'login') {
					self::accountCheck($userData);
					redirect::to("dashboard");
				} else {
					self::accountCheck($userData);
				}
			} else {
				user::logout();
			}
		} elseif (session::exist(AGENT_LOGIN_SESSION) && session::exist(AGENT_SESSION_NAME)) {

			$agent_id = session::get(AGENT_SESSION_NAME);

			$check_agentExist = user::checkExist("user_accounts", "agent_id = '$agent_id'");
			$userData = $db->select("user_accounts", "*", "agent_id = '$agent_id'", "fetch");

			if (!$check_agentExist) {
				user::logout();
			}

			user::login($agent_id);
			if ($from == 'login') {
				self::accountCheck($userData);
				redirect::to("dashboard");
			} else {
				self::accountCheck($userData);
			}
		} else {
			if ($from != 'login') {
				user::logout();
			}
		}
	}

	public static function accountCheck($userdata) {
		$error = NULL;
		$detailsComplete = TRUE;

		$page = explode('/', $_SERVER['REQUEST_URI']);
		array_shift($page);

		$totalPage = count($page);

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$agent_id = $userdata['agent_id'];

		$checkAcc = $db->select("user_accounts", "*", "agent_id = '$agent_id'", "fetch");
		$accType = $checkAcc['acc_type'];

//        DETAILS
		$details = $db->select("user_accounts", "address,country,states,gender,ic_no,mobile", "agent_id = '$agent_id'", "fetch");


		foreach ($details as $key => $value) {

			if (empty($value)) {
				$detailsComplete = FALSE;
			}
		}


//        BANK
		$bank_chk = $userdata['bank_chk'];


//        BENEFICIARY
		$beneficiary_chk = $userdata['beneficiary_chk'];

//        PAYMENT
		$payment = $userdata['payment'];


		if ($userdata['tmp_password'] != NULL) {
			$error = 'password';
		} elseif (!$detailsComplete) {
			if ($accType != 'admin' and $accType != 'md') {
				$error = 'details';
			}
		} elseif ($bank_chk == 0) {
			$error = 'bank';
		} elseif ($beneficiary_chk == 0) {
			$error = 'beneficiary';
		} elseif ($payment == 0) {
			$error = 'payment';
		}

		$redirect = 'setup/' . $error;

		if ($page[0] == 'dashboard' and $totalPage > 1) {
			if ($page[1] != 'logout' and ! empty($error) and $page[0] != 'setup') {
				redirect::to($redirect);
			}
		} elseif (!empty($error) and $page[0] != 'setup') {
			redirect::to($redirect);
		}

		if (!empty($error)) {
			return $redirect;
		} else {
			return FALSE;
		}
	}

}
