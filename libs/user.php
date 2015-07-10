<?php

class user {

	public function __construct() {
		
	}

	public static function getUserData($type, $arg) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("user_accounts", "*", "$type = '$arg'", "fetch");

		return $data;
	}

	public static function getSponsorData($type, $arg, $customData = "*") {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("user_accounts", $customData, "$type = '$arg'", "fetch");

		return $data;
	}

	public static function getSupplierData($type, $arg) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("user_suppliers", "*", "$type = '$arg'", "fetch");

		return $data;
	}
	
	public static function getAdsData($type, $arg) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("advertisement_view", "*", "$type = '$arg'", "fetch");

		return $data;
	}

	public static function getSupplierList($cond, $col = "*") {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("user_suppliers", "$col", "$cond");

		return $data;
	}

	public static function getUserBank($type, $arg) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("user_banks", "*", "$type = '$arg'", "fetch");

		return $data;
	}

	public static function getRegPin() {

		$pinArr = array();

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$data = $db->select("user_accounts", "agent_id", "acc_type = 'ep' AND payment = '2' ORDER BY available_pin DESC");

		foreach ($data as $value) {
			$pinArr[] = $value['agent_id'];
		}

		if (count($pinArr) > 0) {
			$pin = $pinArr[0];
		} else {
			$pin = "1000000";
		}

		return $pin;
	}

	public static function countBadge($table, $where) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->count($table, $where);

		return $data;
	}

	public static function getTotalCommission($agent_id, $f = FALSE) {
		$totalCommission = 0;

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		if ($f == FALSE) {
			$commissions = $db->select("user_commissions", "amount", "agent_id = '$agent_id'");
		} else {
			$commissions = $db->select("user_commissions", "amount", "agent_id = '$agent_id' AND f = 0");
		}



		$countCommissions = count($commissions);

		if ($countCommissions > 0) {
			foreach ($commissions as $value) {
				$totalCommission = $totalCommission + $value['amount'];
			}
		}

		return $totalCommission;
	}

	public static function getTotalPayout($agent_id) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$totalPayout = 0;

		$payout = $db->select("user_withdrawal", "amount", "agent_id = '$agent_id' AND (status = '2' OR status = '1' OR status = '0')");

		$countPayout = count($payout);
		if ($countPayout > 0) {
			foreach ($payout as $value) {
				$totalPayout = $totalPayout + $value['amount'];
			}
		}

		return $totalPayout;
	}

	public static function getAvailableComm($agent_id, $f = FALSE) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$date_now = date("Y-m-d H:i:s");
		$total_available_commission = 0;
		$total_withdrawal = 0;

		if ($f == FALSE) {
			$commission = $db->select("user_commissions", "amount", "agent_id = '$agent_id' AND date_release < '$date_now'");
		} else {
			$commission = $db->select("user_commissions", "amount", "agent_id = '$agent_id' AND date_release < '$date_now' AND f = 0");
		}


		$countComm = count($commission);

		if ($countComm > 0) {
			foreach ($commission as $value) {
				$total_available_commission = $total_available_commission + $value['amount'];
			}
		}

		$withdrawal = $db->select("user_withdrawal", "amount", "agent_id = '$agent_id' AND (status = '2' OR status = '1' OR status = '0')");

		$countWithdrawal = count($withdrawal);
		if ($countWithdrawal > 0) {
			foreach ($withdrawal as $value2) {
				$total_withdrawal = $total_withdrawal + $value2['amount'];
			}
		}

		$total_available_payout = $total_available_commission - $total_withdrawal;

		return $total_available_payout;
	}

	public static function getUserImages($agent_id, $profile = FALSE) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		if ($profile) {
			$data = $db->select("user_images", "*", "agent_id = '$agent_id' AND profile = '1'", "fetch");
		} else {
			$data = $db->select("user_images", "*", "agent_id = '$agent_id'");
		}

		return $data;
	}

	public static function checkExist($tableName, $cond) {

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$data = $db->count($tableName, $cond);

		if ($data > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public static function checkEmail($email) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$data = $db->count("user_accounts", "email = '$email'");

		if ($data == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public static function checkCdata($arg1, $arg2) {
		if ($arg1 != $arg2) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public static function getAccType($code = NULL) {

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		if ($code != NULL) {
			$where = "code = '$code'";
			$fetch = "fetch";
		} else {
			$where = NULL;
			$fetch = "fetchAll";
		}
		$data = $db->select("user_groups", "*", $where, $fetch);

		return $data;
	}

	public static function generateID() {

		$uid = rand(1000000, 9999999);

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$data = $db->count("user_accounts", "agent_id = '$uid'");

		while ($data > 0) {

			$uid = rand(1000000, 9999999);
			$data = $db->count("user_accounts", "agent_id = '$uid'");
		}

		return $uid;
	}

	public static function generateSupplierID() {

		$uid = rand(1000000000, 9999999999);

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$data = $db->count("user_suppliers", "supplier_id = '$uid'");

		while ($data > 0) {

			$uid = rand(1000000000, 9999999999);
			$data = $db->count("user_suppliers", "supplier_id = '$uid'");
		}

		return $uid;
	}
	
	public static function generateAdsID() {

		$uid = rand(100000000, 999999999);

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$data = $db->count("advertisement_view", "ads_id = '$uid'");

		while ($data > 0) {

			$uid = rand(100000000, 999999999);
			$data = $db->count("advertisement_view", "ads_id = '$uid'");
		}

		return $uid;
	}

	public static function checkSponsor($sponsorID) {

		if ($sponsorID == "-1") {
			$sponsorID = self::generateSponsor();

			return $sponsorID;
		} else {

			$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
			$data = $db->count("user_accounts", "agent_id = '$sponsorID'");

			if ($data == 0) {
				$sponsorID = $this->generateSponsor();
			}

			return $sponsorID;
		}
	}

	public static function generateActivationCode($email) {

		$code = hash::create('sha256', $email, HASH_PASSWORD_KEY);

		return $code;
	}

	public static function generateSponsor() {
		$userArr = array();

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$allUser = $db->select("user_accounts", "agent_id");

		foreach ($allUser as $key => $value) {
			$userArr[] = $value['agent_id'];
		}

		$countUsers = array();
		foreach ($userArr as $key => $value) {
			$countUser = $db->count("user_accounts", "sponsor_id = '$value'");
			$countUsers[$value] = $countUser;
		}

		asort($countUsers);
		reset($countUsers);
		$confUser = key($countUsers);

		return $confUser;
	}

	public static function generateUpline($agent_id) {

		$where = "(agent_id = '$agent_id' OR lv1 = '$agent_id' OR lv2 = '$agent_id' OR lv3 = '$agent_id' OR lv4 = '$agent_id' OR lv5 = '$agent_id' OR lv6 = '$agent_id' OR lv7 = '$agent_id' OR lv8 = '$agent_id' OR lv9 = '$agent_id' OR lv10 = '$agent_id') AND (autoplace = '1') ORDER BY id ASC";

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$allUser = $db->select("user_accounts", "agent_id", $where);

		foreach ($allUser as $key => $value) {
			$userID = $value['agent_id'];
			$countLv1 = $db->count("user_accounts", "lv1 = '$userID'");

			if ($countLv1 < 5) {
				break;
			}
		}

		return $userID;
	}

	public static function login($agent_id, $rememberme = FALSE) {
		session::set(AGENT_SESSION_NAME, $agent_id);
		session::set(AGENT_LOGIN_SESSION, TRUE);

		if ($rememberme) {
			if (!cookie::exists(TOKEN_NAME)) {
				$token = hash::create("sha256", $agent_id, HASH_GENERAL_KEY);
				cookie::set(TOKEN_NAME, $token, COOKIE_EXPIRY);

				$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

				$data = array();
				$data['agent_id'] = $agent_id;
				$data['token'] = $token;

				$db->insert("users_session", $data);
			}
		}
	}

	public static function logout() {
		session::destroy();

		$tokenExist = cookie::exists(TOKEN_NAME);

		if ($tokenExist) {

			$token = cookie::get(TOKEN_NAME);

			try {
				$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
				$data = $db->select("users_session", "*", "token = '$token'", "fetch");
				$agent_id = $data['agent_id'];
				$db->delete("users_session", "token = '$agent_id'");
				cookie::delete(TOKEN_NAME);
			} catch (Exception $ex) {
				cookie::delete(TOKEN_NAME);
			}
		}

		redirect::to("login");
	}

	public static function getCountry() {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("country", "*");

		return $data;
	}

	public static function getCategory() {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("category", "*");

		return $data;
	}

	public static function getStates($code) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("country_states", "*", "country_code = '$code'");

		return $data;
	}

	public static function getBanks($code = NULL, $fetch = "fetchAll") {

		if ($code != NULL) {
			$where = "code = '$code'";
		} else {
			$where = NULL;
		}
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("banks", "*", $where, $fetch);

		return $data;
	}

	public static function getPaymentMethod($code = NULL, $fetch = "fetchAll") {

		if ($code != NULL) {
			$where = "code = '$code'";
		} else {
			$where = NULL;
		}
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("payment_method", "*", $where, $fetch);

		return $data;
	}

	public static function checkGeneology($agent_id) {

		$return = FALSE;

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$owner_id = session::get(AGENT_SESSION_NAME);
		$data = $db->select("user_accounts", "lv1,lv2,lv3,lv4,lv5,lv6,lv7,lv8,lv9,lv10", "agent_id = '$agent_id'", "fetch");

		foreach ($data as $value) {
			if ($value == $owner_id) {
				$return = TRUE;
			}
		}
		return $return;
	}

	public static function totalAgents($agent_id) {

		$totalAgents = array();

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		for ($i = 1; $i <= 10; $i++) {
			$key = "lv$i";
			$totalAgents[$key] = $db->count("user_accounts", "$key = '$agent_id'");
		}

		return $totalAgents;
	}

	public static function getMessages($cond = NULL, $fetch = "fetchAll") {
		if ($cond != NULL) {
			$where = $cond;
		} else {
			$where = NULL;
		}
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$data = $db->select("user_messages", "*", $where, $fetch);

		return $data;
	}

}
