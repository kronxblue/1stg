<?php

class messages_model extends model {

    function __construct() {
        parent::__construct();
        session::init();
    }

    public function getMessagesList($agent_id) {
        $data = $this->db->select("user_messages","*","agent_id = '$agent_id' ORDER BY status DESC");
        
        return $data;
    }
}
