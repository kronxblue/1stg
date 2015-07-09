<?php

class token {

    function __construct() {
        
    }

    public static function generate() {
        $token = md5(uniqid());
        return session::set(TOKEN_NAME, hash::create('sha256', $token, HASH_GENERAL_KEY));
    }

    public static function check($token) {
        $tokenName = TOKEN_NAME;

        if (session::exist($tokenName) && $token === session::get($tokenName)) {
            session::delete($tokenName);
            return TRUE;
        }
        
        return FALSE;
    }

}
