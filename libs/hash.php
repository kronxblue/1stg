<?php

class hash {

    function __construct() {
        
    }
    
    /**
     * 
     * @param string $algo The algorithm (md5,sha1,whirlpool, etc)
     * @param string $data The data to encode
     * @param string $salt The salt (should be same throughout the system)
     * @return string
     */
    public static function create($algo, $data, $salt) {
        $context = hash_init($algo, HASH_HMAC, $salt);
        hash_update($context, $data);
        
        return hash_final($context);
    }

}