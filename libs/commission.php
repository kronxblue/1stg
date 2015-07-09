<?php

class commission {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 
	 * @param type $data (agent_id, acc_type, date)
	 * @param type $upgrade (default: false)
	 * @return type
	 */
	public static function generatePDICommission($data, $upgrade = FALSE) {

		$agent_id = $data['agent_id'];

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$userdata = $db->select("user_accounts", "sponsor_id, ads_pin, username", "agent_id = $agent_id", "fetch");

		$commission_data = $db->select("commissions_type", "*", "code = 'pdi'", "fetch");

		$idata = array();


		$idata['ads_pin'] = $userdata['ads_pin'];

		$accDetails = user::getAccType($data['acc_type']);

		$username = $userdata['username'];
		$acc_type = $accDetails['code'];
		$acc_typeLabel = $accDetails['label'];


		if ($upgrade) {
			$idata['subject'] = "[UPGRADE] " . $commission_data['subject'] . " <b>$username - $acc_typeLabel</b>";
		} else {
			$idata['subject'] = $commission_data['subject'] . " <b>$username - $acc_typeLabel</b>";
		}

		$idata['from'] = $agent_id;
		$idata['type'] = $commission_data['code'];

		$dateProcess = $data['date'];

		if (date("d", strtotime($dateProcess)) < 15) {
			$idata['date_release'] = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", strtotime($dateProcess)), 15, date("Y", strtotime($dateProcess))));
		} else {
			$idata['date_release'] = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", strtotime($dateProcess)), date("t", strtotime($dateProcess)), date("Y", strtotime($dateProcess))));
		}

		$idata['date'] = $dateProcess;
		$idata['remarks'] = NULL;
		$idata['f'] = 0;

		$sponsordata = user::getSponsorData("agent_id", $userdata['sponsor_id'], "sponsor_id, agent_id, acc_type");

		$balanceReceiver = array();
		$haveBalance = FALSE;

		switch ($acc_type) {

			case "ad":
				$commissionAmount = 1500;
				if ($sponsordata['acc_type'] == $acc_type) {
					$idata['agent_id'] = $userdata['sponsor_id'];
					$idata['amount'] = $commissionAmount;
				} elseif ($sponsordata['acc_type'] == "ed" or $sponsordata['acc_type'] == "ep" or $sponsordata['acc_type'] == "admin") {
					$idata['agent_id'] = $userdata['sponsor_id'];
					$idata['amount'] = $commissionAmount;
				} else {
					$idata['agent_id'] = $sponsordata['agent_id'];
					$idata['amount'] = 1000;
					$haveBalance = TRUE;

					$sponsorAcc = $sponsordata['acc_type'];
					while ($sponsorAcc == "aa") {
						$sponsordata = user::getSponsorData("agent_id", $sponsordata['sponsor_id'], "sponsor_id, agent_id, acc_type");
						$sponsorAcc = $sponsordata['acc_type'];
					}

					$balanceReceiver['id'] = $sponsordata['agent_id'];
					$balanceReceiver['amount'] = 500;
				}


				break;
			case "ed":
				$commissionAmount = 2500;
				if ($sponsordata['acc_type'] == $acc_type) {
					$idata['agent_id'] = $userdata['sponsor_id'];
					$idata['amount'] = $commissionAmount;
				} else {
					$idata['agent_id'] = $sponsordata['agent_id'];
					$idata['amount'] = 1500;
					$haveBalance = TRUE;

					$sponsorAcc = $sponsordata['acc_type'];
					while ($sponsorAcc == "aa" or $sponsorAcc == "ad") {
						$sponsordata = user::getSponsorData("agent_id", $sponsordata['sponsor_id'], "sponsor_id, agent_id, acc_type");
						$sponsorAcc = $sponsordata['acc_type'];
					}

					$balanceReceiver['id'] = $sponsordata['agent_id'];
					$balanceReceiver['amount'] = 1000;
				}
				break;
			default :
				$idata['agent_id'] = $userdata['sponsor_id'];
				$idata['amount'] = 400;
				break;
		}

		$r = commission::addCommission($idata);

		if ($haveBalance) {
			$idata['agent_id'] = $balanceReceiver['id'];
			$idata['amount'] = $balanceReceiver['amount'];
			$r = commission::addCommission($idata);
		}

		return $r;
	}

	/**
	 * 
	 * @param type $data (agent_id, acc_type, date)
	 * @param type $upgrade (default: false)
	 * @return type
	 */
	public static function generateGDICommission($data, $upgrade = FALSE) {

		$agent_id = $data['agent_id'];

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$userdata = $db->select("user_accounts", "ads_pin, acc_type, username, lv1, lv2, lv3, lv4, lv5, lv6, lv7, lv8, lv9, lv10", "agent_id = $agent_id", "fetch");

		$commission_data = $db->select("commissions_type", "*", "code = 'gdi'", "fetch");

		$idata = array();

		$idata['ads_pin'] = $userdata['ads_pin'];

		$accDetails = user::getAccType($data['acc_type']);

		$username = $userdata['username'];
		$acc_type = $accDetails['code'];
		$acc_typeLabel = $accDetails['label'];


		if ($upgrade) {
			$idata['subject'] = "[UPGRADE] " . $commission_data['subject'] . " <b>$username - $acc_typeLabel</b>";
		} else {
			$idata['subject'] = $commission_data['subject'] . " <b>$username - $acc_typeLabel</b>";
		}

		$idata['from'] = $agent_id;
		$idata['type'] = $commission_data['code'];

		$dateProcess = $data['date'];

		if (date("d", strtotime($dateProcess)) < 15) {
			$idata['date_release'] = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", strtotime($dateProcess)), 15, date("Y", strtotime($dateProcess))));
		} else {
			$idata['date_release'] = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", strtotime($dateProcess)), date("t", strtotime($dateProcess)), date("Y", strtotime($dateProcess))));
		}

		$idata['date'] = $dateProcess;
		$idata['remarks'] = NULL;
		$idata['f'] = 0;

//		Get commission amount

		$commission_lv = array();

		switch ($acc_type) {
			case "ad":
				for ($x = 1; $x < 11; $x++) {
					$commission_lv[$x] = ($x <= 5) ? 100 : 50;
				}
				break;
			case "ed":
				for ($x = 1; $x < 11; $x++) {
					$commission_lv[$x] = ($x <= 5) ? 150 : 50;
				}

				break;

			default:
				for ($x = 1; $x < 11; $x++) {
					$commission_lv[$x] = ($x <= 5) ? 50 : 10;
				}
				break;
		}

//		Sanitize commission receiver

		$receiver = array();

		for ($x = 1; $x < 11; $x++) {
			$receiver["lv$x"] = $userdata["lv$x"];
		}

//		Get receiver account type

		$receiverData = array();

		foreach ($receiver as $key => $value) {
			if ($value != "") {
				$receiverData[$key] = $db->select("user_accounts", "agent_id, acc_type", "agent_id = $value", "fetch");
				switch ($receiverData[$key]['acc_type']) {
					case "aa":
						$receiverData[$key]['lv_limit'] = 4;
						$receiverData[$key]['comm_limit'] = 50;

						break;
					case "ad":
						$receiverData[$key]['lv_limit'] = 6;
						$receiverData[$key]['comm_limit'] = 100;

						break;

					default:
						$receiverData[$key]['lv_limit'] = 10;
						$receiverData[$key]['comm_limit'] = 150;

						break;
				}
			}
		}

//		Generate commission and filter receiver account type

		$count = count($receiverData);
		$hasBalance = FALSE;
		$commissionArray = array();

		$balanceData = array();

		for ($lv = 1; $lv <= $count; $lv++) {

			if ($lv <= $receiverData["lv$lv"]['lv_limit']) {

				$comm_amount = $commission_lv[$lv];

				$diff = ($comm_amount >= $receiverData["lv$lv"]['comm_limit']) ? ($comm_amount - $receiverData["lv$lv"]['comm_limit']) : 0;
				$hasBalance = ($diff == 0) ? FALSE : TRUE;

				$idata['agent_id'] = $receiverData["lv$lv"]['agent_id'];
				$idata['amount'] = ($comm_amount > $receiverData["lv$lv"]['comm_limit']) ? $receiverData["lv$lv"]['comm_limit'] : $comm_amount;

				$commissionArray[$lv] = $idata;

				if ($hasBalance) {
					$balanceData["lv$lv"]['agent_id'] = $receiverData["lv$lv"]["agent_id"];
					$balanceData["lv$lv"]['amount'] = $comm_amount - $idata['amount'];
				} else {
					if (count($balanceData) != 0) {
						$j = 1;
						foreach ($balanceData as $key2 => $value2) {
							$idata['agent_id'] = $receiverData["lv$lv"]['agent_id'];
							$idata['amount'] = $value2['amount'];

							$commissionArray[$lv . "a" . $j] = $idata;
							$j++;
						}

						$balanceData = array();
					}
				}
			}
		}

		foreach ($commissionArray as $value3) {
			$r = commission::addCommission($value3);
		}

		return $r;
	}

	/**
	 * 
	 * @param type $data (agent_id, acc_type, date)
	 * @param type $upgrade (default: false)
	 * @return type
	 */
	public static function generateGAICommission($data, $upgrade = FALSE) {

		$agent_id = $data['agent_id'];

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$userdata = $db->select("user_accounts", "ads_pin, acc_type, username, lv1, lv2, lv3, lv4, lv5, lv6, lv7, lv8, lv9, lv10", "agent_id = $agent_id", "fetch");

		$commission_data = $db->select("commissions_type", "*", "code = 'gai'", "fetch");

		$idata = array();

		$idata['ads_pin'] = $userdata['ads_pin'];

		$accDetails = user::getAccType($data['acc_type']);

		$username = $userdata['username'];
		$acc_typeLabel = $accDetails['label'];


		if ($upgrade) {
			$idata['subject'] = "[UPGRADE] " . $commission_data['subject'] . " <b>$username - $acc_typeLabel</b>";
		} else {
			$idata['subject'] = $commission_data['subject'] . " <b>$username - $acc_typeLabel</b>";
		}

		$idata['from'] = $agent_id;
		$idata['type'] = $commission_data['code'];

		$dateProcess = $data['date'];
		$dateRelease = array();

		for ($i = 0; $i < 12; $i++) {
			$dateRelease[$i + 1] = date("Y-m-t H:i:s", mktime(0, 0, 0, (date("m", strtotime($dateProcess)) + $i), 1, date("Y", strtotime($dateProcess))));
		}

		$idata['date'] = $dateProcess;
		$idata['remarks'] = NULL;
		$idata['f'] = 0;

//		Get commission amount

		$commission_lv = array();

		for ($j = 1; $j <= 10; $j++) {
			switch ($j) {
				case ($j <= 3):
					$commission_lv[$j] = 3;
					break;
				case 4:
					$commission_lv[$j] = 6;
					break;
				case 5:
					$commission_lv[$j] = 5;
					break;
				default:
					$commission_lv[$j] = 1;
					break;
			}
		}

//		Sanitize commission receiver

		$receiver = array();

		for ($x = 1; $x < 11; $x++) {
			if ($userdata["lv$x"] != NULL) {
				$receiver["lv$x"] = $userdata["lv$x"];
				$receiverData["lv$x"] = $db->select("user_accounts", "agent_id, acc_type", "agent_id = " . $receiver["lv$x"], "fetch");
				$receiverData["lv$x"]['amount'] = $commission_lv[$x];

				switch ($receiverData["lv$x"]['acc_type']) {
					case "aa":
						$receiverData["lv$x"]['lv_limit'] = 4;

						break;
					case "ad":
						$receiverData["lv$x"]['lv_limit'] = 6;

						break;

					default:
						$receiverData["lv$x"]['lv_limit'] = 10;
						break;
				}

				if ($x > $receiverData["lv$x"]['lv_limit']) {
					unset($receiverData["lv$x"]);
				}
			}
		}

		$commissionArray = array();
		$k = 1;
		foreach ($receiverData as $key => $value) {
			$idata['agent_id'] = $value['agent_id'];
			$idata['amount'] = $value['amount'];

			$m = 1;
			foreach ($dateRelease as $key2 => $value2) {
				$idata['date_release'] = $value2;
				$commissionArray[$k . "." . $m] = $idata;
				$m++;
			}

			$k++;
		}

		foreach ($commissionArray as $value) {
			$r = commission::addCommission($value);
		}

		return $r;
	}

	/**
	 * 
	 * @param type $data (agent_id, acc_type, date)
	 * @param type $upgrade (default: false)
	 * @return type
	 */
	public static function generateAPRCommission($data) {

		$agent_id = $data['agent_id'];

		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);

		$userdata = $db->select("user_accounts", "ads_pin, acc_type, username", "agent_id = $agent_id", "fetch");

		$commission_data = $db->select("commissions_type", "*", "code = 'apr'", "fetch");

		$idata = array();

		$idata['agent_id'] = $userdata['ads_pin'];
		$idata['ads_pin'] = $userdata['ads_pin'];

		$accDetails = user::getAccType($data['acc_type']);

		$username = $userdata['username'];
		$acc_typeLabel = $accDetails['label'];

		$idata['subject'] = $commission_data['subject'] . " <b>$username - $acc_typeLabel</b>";

		$idata['from'] = $agent_id;
		$idata['type'] = $commission_data['code'];
		$idata['amount'] = 1200;

		$dateProcess = $data['date'];


		$idata['date_release'] = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", strtotime($dateProcess)), date("t", strtotime($dateProcess)), date("Y", strtotime($dateProcess))));

		$idata['date'] = $dateProcess;
		$idata['remarks'] = NULL;
		$idata['f'] = 0;

		$r = commission::addCommission($idata);

		return $r;
	}

	/**
	 * 
	 * @param type $data (agent_id, ads_pin, subject, from, type, amount, date_release, date, remarks, f)
	 * @return type boolean
	 */
	private static function addCommission($data) {
		$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
		$result = $db->insert("user_commissions", $data);
		return $result;
	}

}
