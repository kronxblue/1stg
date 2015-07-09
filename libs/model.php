<?php

class model {

    public $db;

    function __construct() {
        $this->db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
    }

}
