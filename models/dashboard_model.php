<?php

class dashboard_model extends model {

	function __construct() {
		parent::__construct();
	}

	public function totalPinSold($agent_id) {
		$data = $this->db->count("user_accounts", "ads_pin = '$agent_id'");

		return $data;
	}

	public function totalAgentSponsor() {
		$agent_id = session::get(AGENT_SESSION_NAME);
		$data = $this->db->count("user_accounts", "sponsor_id = '$agent_id'");

		return $data;
	}

	public function topSponsor() {
		$idArray = array();

		$header = "<table class='table table-bordered table-condensed'><thead><tr class='active'><th class='text-center' width='50'>#</th><th class='text-center'>Username</th><th class='text-center' width='100'>Total</th></tr></thead><tbody>";
		$content = "";
		$footer = "</tbody></table>";

		$allData = $this->db->select("user_accounts", "agent_id");

		foreach ($allData as $value) {
			$idArray[] = $value['agent_id'];
		}

		$dataArray = array();
		foreach ($idArray as $key => $value) {

			$date = date("Y-m");
			$countSponsor = $this->db->count("user_accounts", "sponsor_id = '$value' AND dt_join LIKE '%$date%'");
			$user = $this->db->select("user_accounts", "username,acc_type", "agent_id = '$value'", "fetch");

			if (($countSponsor != 0) and ( $user['acc_type'] != 'admin')) {
				$dataArray[$user['username']] = $countSponsor;
			}
		}
		arsort($dataArray);
		$dataArray = array_slice($dataArray, 0, 5);

		if (!empty($dataArray)) {
			$i = 1;
			foreach ($dataArray as $key => $value) {
				$content .= "<tr class='text-center'><td>$i</td><td>$key</td><td>$value</td></tr>";
				$i++;
			}
		} else {
			$date = date("M Y");
			$content .= "<tr class='text-center'><td colspan='3'>No top referrer record for $date.</td></tr>";
		}

		$result = $header . $content . $footer;

		return $result;
	}

	public function reminder() {
		$agent_id = session::get(AGENT_SESSION_NAME);
		$r = array();
		$link = BASE_PATH . "setup/";
		$accData = $this->db->select("user_accounts", "bank_chk, beneficiary_chk, payment", "agent_id = '$agent_id'", "fetch");

//		BANK CHECK
		$bank_link = $link . "bank";
		$bankStatus = $accData['bank_chk'];

		if ($bankStatus == 1) {
			$r[] = "You have not complete your bank details. <a href='$bank_link'>Click here to submit your bank details</a>.";
		}

//		BENEFICIARY CHECK
		$beneficiary_link = $link . "beneficiary";
		$beneficiaryStatus = $accData['beneficiary_chk'];
		if ($beneficiaryStatus == 1) {
			$r[] = "You have not complete your beneficiary details. <a href='$beneficiary_link'>Click here to submit your beneficiary details</a>.";
		}

//		PAYMENT CHECK
		$payment_link = $link . "payment";
		$paymentStatus = $accData['payment'];

		switch ($paymentStatus) {
			case "-1":
				$r[] = "Your payment verification is rejected. <a href='$payment_link'>Click here to resubmit your payment details</a>.";
				break;
			case 0:
				$r[] = "You not complete your payment verification. <a href='$payment_link'>Click here to submit your payment details</a>.";
				break;
			case 1:
				$r[] = "Your payment verification is in process. We will notify you when your payment approve.";
				break;

			default:
				break;
		}

		return $r;
	}

}
