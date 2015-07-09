<?php

class login_model extends model {

    function __construct() {
        parent::__construct();
        session::init();
    }

    public function login_exec($data) {
        $response_array = array();

        $username = $data['username'];

        $userExist = user::checkExist("user_accounts", "username = '$username'");

        $rememberme = (isset($data['rememberme'])) ? TRUE : FALSE;

//        check user exist

        if (!$userExist) {

            $response_array['r'] = "false";
            $response_array['msg'] = "<div><strong>Username</strong> does not exist.</div>";
        } else {

            $userData = user::getUserData('username', $username);

//            verify login details
            if ($userData['tmp_password'] == NULL) {
                $password = hash::create('sha256', $data['password'], HASH_PASSWORD_KEY);
                $checkLogin = user::checkExist("user_accounts", "username = '$username' AND password = '$password'");
            } else {
                $password = $data['password'];
                $checkLogin = user::checkExist("user_accounts", "username = '$username' AND tmp_password = '$password'");
            }

//            execute login
            if (!$checkLogin) {
                $response_array['r'] = "false";
                $response_array['msg'] = "<div>Incorrect <strong>Username</strong> or <strong>Password</strong>.</div>";
            } else {

//                update user database
                $updateData = array();
                $updateData['last_login'] = Date('Y-m-d H:i:s');

                $agent_id = $userData['agent_id'];

                $this->db->update("user_accounts", $updateData, "agent_id = '$agent_id'");

//                start login session
                user::login($agent_id, $rememberme);

                $response_array['r'] = "true";
                $response_array['msg'] = BASE_PATH . "dashboard";
            }
        }

        return $response_array;
    }

    public function forgotPass_exec($data) {

        $response_array = array();

        $email = $data['email'];

//        CHECK EMAIL IN SYSTEM
        $emailExist = user::checkExist("user_accounts", "email = '$email'");

        if (!$emailExist) {
            $response_array['r'] = "false";
            $response_array['msg'] = "<div><strong>$email</strong> is not registered email.</div>";
        } else {


//            CHECK ACCOUNT STATUS
            $userdata = $this->db->select("user_accounts", "*", "email = '$email'", "fetch");

            $activate = $userdata['activate'];

            if ($activate == 0) {
                $response_array['r'] = "false";
                $response_array['msg'] = "<div><strong>$email</strong> is not activate. Please request your activation link (if you don't receive activation email) by clicking '<b>Don't receive activation email? Click here.</b>' link below. </div>";
            } else {
                
//            RESET PASSWORD
//            SEND PASSWORD TO AGENT

                $response_array['r'] = "true";
                $response_array['msg'] = "$userdata";
            }
        }

        return $response_array;
    }

}
