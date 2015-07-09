<?php

class redirect {

    function __construct() {
        
    }

    public static function to($location = NULL, $external = FALSE) {

        if ($external) {
            header('location: ' . $location);
        } else {
            if ($location != NULL) {
                header('location: ' . BASE_PATH . $location);
            } else {
                header('location: ' . BASE_PATH);
            }
        }
        exit();
    }

}
