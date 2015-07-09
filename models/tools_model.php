<?php

class tools_model extends model {

	function __construct() {
		parent::__construct();
	}

	public function tools() {

		$data = $this->db->select("tools", "*", "status = '1'");

		return $data;
	}

	public function download($id) {
		$response_array = array();

		$data = $this->db->select("tools", "*", "id = '$id'", "fetch");

		if ($data == FALSE) {
			$response_array['r'] = "false";
			$response_array['msg'] = "The file that you try to download is doesn't exist.";
		} else {
			$file = TOOLS_PATH . $data['file'];
			$filepath = "public/tools/" . $data['file'];

			if (!file_exists($filepath)) {
				$response_array['r'] = "false";
				$response_array['msg'] = "The file that you try to download is doesn't exist.";
			} else {

				$dcount = $data['dcount'] + 1;
				$updateData = array("dcount" => $dcount);

				$this->db->update("tools", $updateData, "id = '$id'");

				$response_array['r'] = "true";
				$response_array['msg'] = $file;
			}
		}

		return $response_array;
	}

}
