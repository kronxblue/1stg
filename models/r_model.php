<?php

class r_model extends model {

    function __construct() {
        parent::__construct();
        session::init();
    }

    public function s($sponsor) {


        $userData = user::checkExist("user_accounts", "agent_id = '$sponsor' or username = '$sponsor'");

        if ($userData == 1) {

            $getUserData = $this->db->select("user_accounts", "agent_id, username", "agent_id = '$sponsor' or username = '$sponsor'", "fetch");

            $chkCookie = cookie::exists(COOKIE_SPONSOR_NAME);

            if ($chkCookie) {
                $cookieName = cookie::get(COOKIE_SPONSOR_NAME);

                if ($cookieName != $getUserData['agent_id']) {
                    cookie::delete(COOKIE_SPONSOR_NAME);
                    cookie::set(COOKIE_SPONSOR_NAME, $getUserData['agent_id'], COOKIE_EXPIRY);
                }
                
            } else {
                cookie::set(COOKIE_SPONSOR_NAME, $getUserData['agent_id'], COOKIE_EXPIRY);
            }
        } else {
            cookie::delete(COOKIE_SPONSOR_NAME);
        }

        redirect::to(BASE_PATH, TRUE);
    }

}
